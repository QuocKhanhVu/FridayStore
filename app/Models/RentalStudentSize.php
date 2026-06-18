<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalStudentSize extends Model
{
    protected $fillable = [
        'rental_student_id',
        'costume_id',
        'costume_size_id',
    ];

    public function student()
    {
        return $this->belongsTo(
            RentalStudent::class,
            'rental_student_id'
        );
    }

    public function costume()
    {
        return $this->belongsTo(
            Costume::class
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
