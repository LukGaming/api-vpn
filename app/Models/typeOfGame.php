<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class typeOfGame extends Model
{
    protected $filliable = [
        'id',
        'name',
        'description'
    ];
}
