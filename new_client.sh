#!/bin/bash
#
# https://github.com/Nyr/openvpn-install
#
# Copyright (c) 2013 Nyr. Released under the MIT License.


if grep -qs "14.04" /etc/os-release; then
	echo "Ubuntu 14.04 is too old and not supported"
	exit
fi

if grep -qs "jessie" /etc/os-release; then
	echo "Debian 8 is too old and not supported"
	exit
fi

if grep -qs "CentOS release 6" /etc/redhat-release; then
	echo "CentOS 6 is too old and not supported"
	exit
fi

if grep -qs "Ubuntu 16.04" /etc/os-release; then
	echo 'Ubuntu 16.04 is no longer supported in the current version of openvpn-install
Use an older version if Ubuntu 16.04 support is needed: https://git.io/vpn1604'
	exit
fi

# Detect Debian users running the script with "sh" instead of bash
if readlink /proc/$$/exe | grep -q "dash"; then
	echo "This script needs to be run with bash, not sh"
	exit
fi

if [[ "$EUID" -ne 0 ]]; then
	echo "Sorry, you need to run this as root"
	exit
fi

if [[ ! -e /dev/net/tun ]]; then
	echo "The TUN device is not available
You need to enable TUN before running this script"
	exit
fi

if [[ -e /etc/debian_version ]]; then
	os="debian"
	group_name="nogroup"
elif [[ -e /etc/centos-release || -e /etc/redhat-release ]]; then
	os="centos"
	group_name="nobody"
else
	echo "Looks like you aren't running this installer on Debian, Ubuntu or CentOS"
	exit
fi

new_client () {
	# Generates the custom client.ovpn
	{
	cat /etc/openvpn/server/client-common.txt
	echo "<ca>"
	cat /etc/openvpn/server/easy-rsa/pki/ca.crt
	echo "</ca>"
	echo "<cert>"
	sed -ne '/BEGIN CERTIFICATE/,$ p' /etc/openvpn/server/easy-rsa/pki/issued/"$1".crt
	echo "</cert>"
	echo "<key>"
	cat /etc/openvpn/server/easy-rsa/pki/private/"$1".key
	echo "</key>"
	echo "<tls-crypt>"
	sed -ne '/BEGIN OpenVPN Static key/,$ p' /etc/openvpn/server/tc.key
	echo "</tls-crypt>"
	} > ~/"$1".ovpn
}

if [[ -e /etc/openvpn/server/server.conf ]]; then
	while :
	do
	clear
		echo "Looks like OpenVPN is already installed."
		echo
		echo "What do you want to do?"
		echo "   1) Add a new user"
		echo "   2) Revoke an existing user"
		echo "   3) Remove OpenVPN"
		echo "   4) Exit"
		read -p "Select an option: " option
		until [[ "$option" =~ ^[1-4]$ ]]; do
			echo "$option: invalid selection."
			read -p "Select an option: " option
		done
		case "$option" in
			1) 
			echo
			echo "Tell me a name for the client certificate."
			read -p "Client name: " unsanitized_client
			client=$(sed 's/[^0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-]/_/g' <<< "$unsanitized_client")
			while [[ -z "$client" || -e /etc/openvpn/server/easy-rsa/pki/issued/"$client".crt ]]; do
				echo "$client: invalid client name."
				read -p "Client name: " unsanitized_client
				client=$(sed 's/[^0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-]/_/g' <<< "$unsanitized_client")
			done
			cd /etc/openvpn/server/easy-rsa/
			EASYRSA_CERT_EXPIRE=3650 ./easyrsa build-client-full "$client" nopass
			# Generates the custom client.ovpn
			new_client "$client"
			echo
			echo "Client $client added, configuration is available at:" ~/"$client.ovpn"
			exit
			;;
			2)
			# This option could be documented a bit better and maybe even be simplified
			# ...but what can I say, I want some sleep too
			
	# Generates the custom client.ovpn
	new_client "$client"
	echo
	echo "Finished!"
	echo
	echo "Your client configuration is available at:" ~/"$client.ovpn"
	echo "If you want to add more clients, just run this script again!"
fi
