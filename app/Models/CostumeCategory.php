<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostumeCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status'
    ];
}
