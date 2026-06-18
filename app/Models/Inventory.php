<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
        protected $fillable = [
        'costume_id',
        'costume_size_id',
        'quantity',
        'quantity_total',
        'quantity_rented',
        'quantity_available',
        'rented_quantity',
        'broken_quantity',
        'lost_quantity',
    ];

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

    public function logs()
    {
        return $this->hasMany(
            InventoryLog::class,
            'inventory_id'
        );
    }

    public function getAvailableAttribute()
    {
        return

            $this->quantity
            - $this->rented_quantity
            - $this->broken_quantity
            - $this->lost_quantity;
    }
}