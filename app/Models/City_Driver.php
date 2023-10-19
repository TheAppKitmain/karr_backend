<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City_Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'city_id',
        'driver_id',
        'status',
        'date',
        'notes',
        'user_id',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class); 
    }

    public function city()
    {
        return $this->belongsTo(City::class); 
    }
    


}
