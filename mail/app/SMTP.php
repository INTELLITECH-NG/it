<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMTP extends Model
{
    protected $fillable = [
        'driver', 'host', 'port','username', 'password', 'encryption','status'
    ];
}
