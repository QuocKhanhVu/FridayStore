<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToWarehouse;

class Rental extends Model
{
    use BelongsToWarehouse;

    protected $fillable = [
        'user_id',
        'code',
        'studio_id',
        'concept_id',
        'second_concept_id',
        'extra_costume_id',
        'graduation_costume_id',
        'female_accessory_id',
        'male_accessory_id',
        'school_name',
        'class_name',
        'shooting_date',
        'rental_date',
        'return_date',
        'student_count',
        'total_amount',
        'status',
        'processing_note',
        'note',
    ];

    protected $casts = [
        'shooting_date' => 'date',
        'rental_date' => 'date',
        'return_date' => 'date',
        'student_count' => 'integer',
        'total_amount' => 'integer',
    ];

    public function studio()
    {
        return $this->belongsTo(
            Studio::class
        );
    }

    public function concept()
    {
        return $this->belongsTo(
            Concept::class
        );
    }

    public function secondConcept()
    {
        return $this->belongsTo(
            Concept::class,
            'second_concept_id'
        );
    }

    public function extraCostume()
    {
        return $this->belongsTo(
            Costume::class,
            'extra_costume_id'
        );
    }

    public function graduation()
    {
        return $this->belongsTo(
            Costume::class,
            'graduation_costume_id'
        );
    }

    public function femaleAccessory()
    {
        return $this->belongsTo(
            Costume::class,
            'female_accessory_id'
        );
    }

    public function maleAccessory()
    {
        return $this->belongsTo(
            Costume::class,
            'male_accessory_id'
        );
    }

    public function students()
    {
        return $this->hasMany(
            RentalStudent::class
        );
    }

    public function costumes()
    {
        return $this->belongsToMany(
            Costume::class,
            'rental_costumes'
        )->withPivot('quantity');
    }
    public function revenues()
    {
        return $this->hasMany(
            RentalRevenue::class
        );
    }
    public function extraItems()
    {
        return $this->hasMany(RentalExtraItem::class);
    }
    public function extraCostumes()
    {
        return $this->belongsToMany(
            Costume::class,
            'rental_extra_costume',
            'rental_id',
            'costume_id'
        )->withTimestamps();
    }
}
