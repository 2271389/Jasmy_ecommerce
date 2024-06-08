<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductListShop extends Model
{
    use HasFactory;

    protected $table = 'product_list_shops'; // Assuming your table name is 'product_list_shops'

    protected $fillable = [
        'title',
        'price',
        'special_price',
        'category',
        'subcategory',
        'remark',
        'brand',
        'product_code',
        'image',
        'top_text',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory', 'id');
    }

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class, 'product_id', 'id');
    }
}
