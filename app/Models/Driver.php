<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Driver extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'name', 'number', 'license', 'password',
        'email', 'user_id',
    ];
    public function paytolls()
    {
        return $this->belongsToMany(Paytoll::class);
    }
    public function cities()
    {
        return $this->belongsToMany(City::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function cityDrivers()
    {
        return $this->hasMany(City_Driver::class);
    }
    public function tollDrivers()
    {
        return $this->hasMany(Paytoll_Driver::class);
    }
    
}
