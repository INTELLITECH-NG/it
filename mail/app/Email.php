<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
	protected $fillable = [
        'name', 'email', 'group_id', 'address', 'remarks',
    ];

    public function Group()
    {
        return $this->belongsTo('App\Group');
    }
}
