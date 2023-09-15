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
    public function driver()
    {
        return $this->belongsToMany(Driver::class);
    }

}
