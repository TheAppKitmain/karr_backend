<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paytoll_Driver extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'paytoll_id',
        'driver_id',
        'status',
        'date',
        'way',
        'notes',
        'user_id',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class); 
    }

    public function paytoll()
    {
        return $this->belongsTo(Paytoll::class); 
    }

}
