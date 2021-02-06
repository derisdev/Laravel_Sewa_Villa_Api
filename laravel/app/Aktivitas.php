<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Model
{
    protected $fillable = [
        'villa_id','imageUrl','name','type','startTimes','rating','price'
    ];

    public function villas()
    {
        return $this->belongsTo(Villa::class);
    }
}
