<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeRule extends Model
{
    protected $table = 'size_rules';

    protected $fillable = [

        'costume_size_id',

        'height_from',
        'height_to',

        'weight_from',
        'weight_to',

    ];

    protected $casts = [

        'height_from' => 'float',
        'height_to'   => 'float',

        'weight_from' => 'float',
        'weight_to'   => 'float',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function costumeSize()
    {
        return $this->belongsTo(
            CostumeSize::class,
            'costume_size_id'
        );
    }
}