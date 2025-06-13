<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone',
        'topic',
        'details',
        'date',
        'time',
         'meeting_link'
    ];
}
