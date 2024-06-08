<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_num_us',
        'name',
        'status',
        'day_order',
        'qty',
        'y_no',
        'distance'
    ];
}
