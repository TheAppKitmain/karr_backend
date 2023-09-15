<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paytoll extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'name', 'time', 'price','day',
    ];
    public function drivers()
    {
        return $this->belongsToMany(Driver::class);
    }
    

}
