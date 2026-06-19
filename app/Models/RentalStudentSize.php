<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToWarehouse;

class RentalStudentSize extends Model
{
    use BelongsToWarehouse;

    protected $fillable = [
        'user_id',
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
