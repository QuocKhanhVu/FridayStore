<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToWarehouse;

class RentalStudent extends Model
{
    use BelongsToWarehouse;

    protected $fillable = [
        'user_id',

        'rental_id',

        'full_name',

        'gender',

        'height',

        'weight'

    ];

    public function rental()
    {
        return $this->belongsTo(
            Rental::class
        );
    }

    public function sizes()
    {
        return $this->hasMany(
            RentalStudentSize::class
        );
    }
    public function assignedSizes()
    {
        return $this->hasMany(RentalStudentSize::class);
    }
}