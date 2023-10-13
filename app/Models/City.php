<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'area',
        'city',
        'time',
        'price',
    ];
    public function drivers()
    {
        return $this->belongsToMany(Driver::class);
    }
    public function cityDrivers()
    {
        return $this->hasMany(City_Driver::class);
    }
}
