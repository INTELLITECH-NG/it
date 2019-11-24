<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendMail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'smtp_mail', 'name', 'subject', 'message', 'recipients',
    ];
}
