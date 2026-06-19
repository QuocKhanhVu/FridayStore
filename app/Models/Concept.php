<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToWarehouse;

class Concept extends Model
{
    use BelongsToWarehouse;

    protected $fillable = [
        'user_id',

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
