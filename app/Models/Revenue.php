<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToWarehouse;

class Revenue extends Model
{
    use BelongsToWarehouse;

    protected $fillable = [
        'user_id',
        'rental_id',
        'concept_id',
        'price',
        'student_count',
        'total_amount',
        'discount_percent',
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