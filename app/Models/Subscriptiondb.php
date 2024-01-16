<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptiondb extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'trial_start',
        'trial_end',
        'customer'
    ];
}
