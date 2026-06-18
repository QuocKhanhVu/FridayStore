<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalRevenue extends Model
{
    protected $fillable = [
        'rental_id',
        'concept_id',
        'student_count',
        'price',
        'discount_percent',
        'total_amount',
        'discount_amount',
        'final_amount',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function concept()
    {
        return $this->belongsTo(Concept::class);
    }
}