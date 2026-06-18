<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $fillable = [

        'name',
        'phone',
        'email',
        'address',
        'contact_person',
        'note',
        'status'

    ];
    
}