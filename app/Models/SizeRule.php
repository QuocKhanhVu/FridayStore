<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToWarehouse;

class SizeRule extends Model
{
    use BelongsToWarehouse;

    protected $table = 'size_rules';

    protected $fillable = [
        'user_id',

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