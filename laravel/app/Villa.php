<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Villa extends Model
{
    protected $fillable = [
        'imageUrl','description','nama','harga','kapasitas','fasilitas','latitude','longitude'
    ];

    public function aktivitas()
    {
        return $this->hasMany(Aktivitas::class);
    }

}
