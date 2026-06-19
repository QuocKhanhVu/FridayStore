<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToWarehouse;

class Costume extends Model
{
    use BelongsToWarehouse;

    protected $fillable = 
    [
        'user_id',
    'category_id',
    'code',
    'name',
    'gender',
    'has_size',
    'rental_price',
    'image',
    'description',
    'status',
    ];
    public function category()
    {
        return $this->belongsTo(
            CostumeCategory::class,
            'category_id'
        );
    }
    public function sizes()
    {
        return $this->hasMany(
            CostumeSize::class,
            'costume_id'
        );
    }
    public function inventories()
    {
        return $this->hasMany(
            Inventory::class,
            'costume_id'
        );
    }
   public function concepts()
    {
        return $this->belongsToMany(
            Concept::class,
            'concept_costume'
        );
    }
    public function rentals()
    {
        return $this->belongsToMany(
            Rental::class,
            'rental_costumes'
        )->withPivot('quantity');
    }
}
