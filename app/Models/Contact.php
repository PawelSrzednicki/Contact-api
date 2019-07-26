<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
     protected $fillable = [
        'name', 'lastname', 'address', 'email', 'telephone'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
