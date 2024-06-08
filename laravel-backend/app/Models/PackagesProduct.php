<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagesProduct extends Model
{
    use HasFactory;

    protected $fillable = [ //Truyền vào các trường của data
        'package_id',
        'product_id',
        'quantity',
        'price',
    ];
}
