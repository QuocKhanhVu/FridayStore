<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    protected $fillable = [

        'name',
        'slug',
        'thumbnail',
        'description',
        'price',
        'discount_percent',
        'status'

    ];

    public function costumes()
    {
        return $this->belongsToMany(
            Costume::class,
            'concept_costume'
        );
    }
}
