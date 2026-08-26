<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
    protected $fillable = [
        'type',
        'date',
        'title',
        'amount',
        'category',
    ];
}
