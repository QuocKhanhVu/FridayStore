<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToWarehouse;

class RentalRevenue extends Model
{
    use BelongsToWarehouse;

    protected $fillable = [
        'user_id',
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