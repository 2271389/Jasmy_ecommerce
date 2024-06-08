<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [ //Truyền vào các trường của data
        'category_id',
        'title',
        'slug',
        'price',
        'special_price',
        'image',
        'category',
        'subcategory',
        'remark',
        'brand',
        'star',
        'product_code',
        'stock',
        'active',
        'price_sale',
    ];

    //quann hệ 1 nhiều
    public function menu()
    {
        return $this->hasOne(Category::class, 'id', 'category_id')
            ->withDefault(['title' => '']);
    }
}
