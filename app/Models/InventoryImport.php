<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToWarehouse;

class InventoryImport extends Model
{
    use BelongsToWarehouse;

    protected $fillable = [
        'user_id',
    ];

    //
}
