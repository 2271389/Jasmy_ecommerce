<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDetail;

class ProductDetailController extends Controller
{
	public function ProductDetail(Request $request)
	{
		$id = $request->id;
		$product = Product::where('id', $id)->get();
		$productDetail = ProductDetail::where('product_id', $id)->get();
		$reviews = ProductReview::where('product_id', $id)->get();
		$result = [
			'product' => $product,
			'detail' => $productDetail,
			'reviews' => $reviews
		];
		return $result;
	}
}
