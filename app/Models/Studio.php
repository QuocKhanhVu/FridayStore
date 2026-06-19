<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToWarehouse;

class Studio extends Model
{
    use BelongsToWarehouse;

    protected $fillable = [
        'user_id',

        'name',
        'phone',
        'email',
        'address',
        'contact_person',
        'note',
        'status'

    ];
    
}