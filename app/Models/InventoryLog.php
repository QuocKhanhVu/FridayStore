<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    protected $fillable = [

        'costume_id',

        'costume_size_id',

        'type',

        'quantity',

        'note'

    ];

    public function inventory()
    {
        return $this->belongsTo(
            Inventory::class,
            'inventory_id'
        );
    }
    public function costume()
    {
        return $this->belongsTo(
            Costume::class,
            'costume_id'
        );
    }

    public function size()
    {
        return $this->belongsTo(
            CostumeSize::class,
            'costume_size_id'
        );
    }
}