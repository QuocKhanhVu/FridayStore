<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalStudent extends Model
{
    protected $fillable = [

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