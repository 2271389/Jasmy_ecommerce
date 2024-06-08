<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductListShop;
use App\Models\ProductDetail;
use App\Models\Category;
use App\Models\Subcategory;
use Intervention\Image\Facades\Image;

class ProductListShopController extends Controller
{
    public function ProductListByRemark(Request $request)
    {
        $remark = $request->remark;
        $products = ProductListShop::where('remark', $remark)->get();
        return $products;
    }

    public function ProductListByCategory(Request $request)
    {
        $cat = $request->category;
        $products = ProductListShop::where('category', $cat)->get();
        return $products;
    }

    public function ProductListBySubcategory(Request $request)
    {
        $cat = $request->category;
        $subcat = $request->subcategory;
        $products = ProductListShop::where('subcategory', $subcat)->where('category', $cat)->get();
        return $products;
    }

    public function ProductListBySearch(Request $request)
    {
        $key = $request->key;
        $products = ProductListShop::where('title', 'LIKE', "%{$key}%")
            ->orWhere('brand', 'LIKE', "%{$key}%")
            ->get();
        return $products;
    }

    public function SimilarProduct(Request $request)
    {
        $subcategory = $request->subcategory;
        $productlist = ProductListShop::where('subcategory', $subcategory)->orderBy('id', 'desc')->limit(6)->get();
        return $productlist;
    }

    public function GetAllProduct()
    {
        $products = ProductListShop::latest()->paginate(2);
        return view('backend.product.product_all', compact('products'));
    }

    public function AddProduct()
    {
        $category = Category::orderBy('category_name', 'ASC')->get();
        $subcategory = Subcategory::orderBy('subcategory_name', 'ASC')->get();
        return view('backend.product.product_add', compact('category', 'subcategory'));
    }

    public function StoreProduct(Request $request)
    {
        $request->validate([
            'product_code' => 'required',
        ], [
            'product_code.required' => 'Input Product Code'
        ]);

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(711, 960)->save('upload/product/' . $name_gen);
        $save_url = 'http://127.0.0.1:8000/upload/product/' . $name_gen;

        $product_id = ProductListShop::insertGetId([
            'title' => $request->title,
            'price' => $request->price,
            'special_price' => $request->special_price,
            'category' => $request->category,
            'subcategory' => $request->subcategory,
            'remark' => $request->remark,
            'brand' => $request->brand,
            'product_code' => $request->product_code,
            'image' => $save_url,
        ]);

        $this->storeProductDetails($request, $product_id);

        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.product')->with($notification);
    }

    public function EditProduct($id)
    {
        $category = Category::orderBy('category_name', 'ASC')->get();
        $subcategory = Subcategory::orderBy('subcategory_name', 'ASC')->get();
        $product = ProductListShop::findOrFail($id);
        $details = ProductDetail::where('product_id', $id)->get();
        return view('backend.product.product_edit', compact('category', 'subcategory', 'product', 'details'));
    }

    public function UpdateProduct(Request $request)
    {
        $product_id = $request->id;

        $request->validate([
            'product_code' => 'required',
        ], [
            'product_code.required' => 'Input Product Code'
        ]);

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $image->move('adminassets/upload/product/', $name_gen);
        $save_url = 'http://127.0.0.1:8000/adminassets/upload/product/' . $name_gen;

        ProductListShop::findOrFail($product_id)->update([
            'title' => $request->title,
            'price' => $request->price,
            'special_price' => $request->special_price,
            'category' => $request->category,
            'subcategory' => $request->subcategory,
            'remark' => $request->remark,
            'brand' => $request->brand,
            'top_text' => $request->top_text,
            'product_code' => $request->product_code,
            'image' => $save_url,
        ]);

        $this->updateProductDetails($request, $product_id);

        return redirect()->route('admin.all.product');
    }

    private function storeProductDetails(Request $request, $product_id)
    {
        $images = ['image_one', 'image_two', 'image_three', 'image_four'];
        $save_urls = [];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                $file = $request->file($image);
                $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                Image::make($file)->resize(711, 960)->save('upload/productdetails/' . $name_gen);
                $save_urls[$image] = 'http://127.0.0.1:8000/upload/productdetails/' . $name_gen;
            }
        }

        ProductDetail::insert([
            'product_id' => $product_id,
            'image_1' => $save_urls['image_one'] ?? null,
            'image_2' => $save_urls['image_two'] ?? null,
            'image_3' => $save_urls['image_three'] ?? null,
            'image_4' => $save_urls['image_four'] ?? null,
            'short_description' => $request->short_description,
            'color' => $request->color,
            'size' => $request->size,
            'long_description' => $request->long_description,
        ]);
    }

    private function updateProductDetails(Request $request, $product_id)
    {
        $images = ['image_one', 'image_two', 'image_three', 'image_four'];
        $save_urls = [];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                $file = $request->file($image);
                $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                $file->move('adminassets/upload/productdetails/', $name_gen);
                $save_urls[$image] = 'http://127.0.0.1:8000/adminassets/upload/productdetails/' . $name_gen;
            }
        }

        ProductDetail::where('product_id', $product_id)->update([
            'image_1' => $save_urls['image_one'] ?? null,
            'image_2' => $save_urls['image_two'] ?? null,
            'image_3' => $save_urls['image_three'] ?? null,
            'image_4' => $save_urls['image_four'] ?? null,
            'short_description' => $request->short_description,
            'color' => $request->color,
            'size' => $request->size,
            'other_attr' => $request->other_attr,
            'long_description' => $request->long_description,
        ]);
    }
}
