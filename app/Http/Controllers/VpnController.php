<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VpnController extends Controller
{
    public function store(Request $request)
    {
        echo shell_exec('bash /compartilhada/new_client.sh ' . $request->username);
    }
}
