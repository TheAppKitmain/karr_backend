<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'pcn',
        'driver_id',
        'date',
        'ticket_issuer',
        'status',
        'price',
    ];
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
