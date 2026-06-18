<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostumeSize extends Model
{
    protected $fillable = [

        'costume_id',
        'size_name',
        'display_order',
        'status'

    ];

    public function costume()
    {
        return $this->belongsTo(
            Costume::class,
            'costume_id'
        );
    }

    public function rule()
    {
        return $this->hasOne(
            SizeRule::class,
            'costume_size_id'
        );
    }

    public function inventory()
    {
        return $this->hasOne(
            Inventory::class,
            'costume_size_id'
        );
    }
   
}