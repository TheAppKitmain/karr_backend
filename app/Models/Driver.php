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
        'email',
    ];
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function paytolls()
    {
        return $this->belongsToMany(Paytoll::class);
    }
    public function cities()
    {
        return $this->belongsToMany(City::class);
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
