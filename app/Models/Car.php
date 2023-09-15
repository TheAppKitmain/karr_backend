<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        'make' , 'number', 'dor',
        'year','capacity','co','fuel','euro','rde',
        'export','status','image',
    ];
    public function driver() 
    {
        return $this->hasOne(Driver::class);
        
    }
}