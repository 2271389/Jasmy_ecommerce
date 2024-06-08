<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductListShop;
use App\Models\ProductDetail;
use App\Models\Category;
use App\Models\Subcategory;
use Intervention\Image\Facades\Image as Image;

class ProductController extends Controller
{
    public function ProductListByRemark(Request $request)
    {
        $remark = $request->remark; //Featured, New... tachs biet ra
        $products = Product::where('remark', $remark)->get();
        return $products;
    }
    public function ProductListByCategory(Request $request)
    {
        $cat = $request->category; //Featured, New... tachs biet ra
        $products = Product::where('category', $cat)->get();
        return $products;
    }
    public function ProductListBySubcategory(Request $request)
    {
        $cat = $request->category; //Featured, New... tachs biet ra
        $subcat = $request->subcategory; //Featured, New... tachs biet ra
        $products = Product::where('subcategory', $subcat)->where('category', $cat)->get();
        return $products;
    }

    public function ProductListBySearch(Request $request)
    {
        $key = $request->key;
        $products = Product::where('title', 'LIKE', "%{$key}%")->orWhere('brand', 'LIKE', "%{$key}%")->get();
        return $products;
    }

    public function SimilarProduct(Request $request)
    {
        $subcategory = $request->subcategory;
        $productlist = Product::where('subcategory', $subcategory)->orderBy('id', 'desc')->limit(6)->get();
        return $productlist;
    } // End Method

    //for admin
    public function GetAllProduct()
    {

        $products = Product::latest()->get();
        // $products = Product::latest()->paginate(2);
        $products = Product::latest()->paginate(10); // Adjust the number per page as needed
        return view('backend.product.product_all', compact('products'));
    } // End Method

    public function AddProduct()
    {

        $category = Category::orderBy('category_name', 'ASC')->get();
        $subcategory = Subcategory::orderBy('subcategory_name', 'ASC')->get();
        return view('backend.product.product_add', compact('category', 'subcategory'));
    } // End Method

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

        $product_id = Product::insertGetId([
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

        /////// Insert Into Product Details Table //////
        $image1 = $request->file('image_one');
        $name_gen1 = hexdec(uniqid()) . '.' . $image1->getClientOriginalExtension();
        Image::make($image1)->resize(711, 960)->save('upload/productdetails/' . $name_gen1);
        $save_url1 = 'http://127.0.0.1:8000/upload/productdetails/' . $name_gen1;


        $image2 = $request->file('image_two');
        $name_gen2 = hexdec(uniqid()) . '.' . $image2->getClientOriginalExtension();
        Image::make($image2)->resize(711, 960)->save('upload/productdetails/' . $name_gen2);
        $save_url2 = 'http://127.0.0.1:8000/upload/productdetails/' . $name_gen2;


        $image3 = $request->file('image_three');
        $name_gen3 = hexdec(uniqid()) . '.' . $image3->getClientOriginalExtension();
        Image::make($image1)->resize(711, 960)->save('upload/productdetails/' . $name_gen3);
        $save_url3 = 'http://127.0.0.1:8000/upload/productdetails/' . $name_gen3;



        $image4 = $request->file('image_four');
        $name_gen4 = hexdec(uniqid()) . '.' . $image4->getClientOriginalExtension();
        Image::make($image4)->resize(711, 960)->save('upload/productdetails/' . $name_gen4);
        $save_url4 = 'http://127.0.0.1:8000/upload/productdetails/' . $name_gen4;

        ProductDetail::insert([
            'product_id' => $product_id,
            'image_1' => $save_url1,
            'image_2' => $save_url2,
            'image_3' => $save_url3,
            'image_4' => $save_url4,
            'short_description' => $request->short_description,
            'color' => $request->color,
            'size' => $request->size,
            'long_description' => $request->long_description,

        ]);


        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.product')->with($notification);
    } // End Method

    public function EditProduct($id)
    {
        $category = Category::orderBy('category_name', 'ASC')->get();
        $subcategory = Subcategory::orderBy('subcategory_name', 'ASC')->get();
        $product = Product::findOrFail($id);
        $details = ProductDetail::where('product_id', $id)->get();
        return view('backend.product.product_edit', compact('category', 'subcategory', 'product', 'details'));
    }

    public function UpdateProduct(Request $request)
    {

        $product_id = $request->id; // define product id here

        $request->validate([
            'product_code' => 'required',
        ], [
            'product_code.required' => 'Input Product Code'
        ]);

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $image->move('adminassets/upload/product/', $name_gen);
        $save_url = 'http://127.0.0.1:8000/adminassets/upload/product/' . $name_gen;

        ProductListShop::findOrFail($product_id)->update([ /// chekc this method change it accordingly
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


        /////// Insert Into Product Details Table //////

        $image1 = $request->file('image_one');
        $name_gen1 = hexdec(uniqid()) . '.' . $image1->getClientOriginalExtension();
        // Image::make($image1)->resize(711,960)->save('upload/productdetails/'.$name_gen1);
        $image1->move('adminassets/upload/productdetails/', $name_gen1);
        $save_url1 = 'http://127.0.0.1:8000/adminassets/upload/productdetails/' . $name_gen1;

        $image2 = $request->file('image_two');
        $name_gen2 = hexdec(uniqid()) . '.' . $image2->getClientOriginalExtension();
        // Image::make($image2)->resize(711,960)->save('upload/productdetails/'.$name_gen2);
        $image2->move('adminassets/upload/productdetails/', $name_gen2);
        $save_url2 = 'http://127.0.0.1:8000/adminassets/upload/productdetails/' . $name_gen2;

        $image3 = $request->file('image_three');
        $name_gen3 = hexdec(uniqid()) . '.' . $image3->getClientOriginalExtension();
        // Image::make($image1)->resize(711,960)->save('upload/productdetails/'.$name_gen3);
        $image3->move('adminassets/upload/productdetails/', $name_gen3);
        $save_url3 = 'http://127.0.0.1:8000/adminassets/upload/productdetails/' . $name_gen3;

        $image4 = $request->file('image_four');
        $name_gen4 = hexdec(uniqid()) . '.' . $image4->getClientOriginalExtension();
        // Image::make($image4)->resize(711,960)->save('upload/productdetails/'.$name_gen4);
        $image4->move('adminassets/upload/productdetails/', $name_gen4);
        $save_url4 = 'http://127.0.0.1:8000/adminassets/upload/productdetails/' . $name_gen4;

        ProductDetail::where('product_id', $product_id)->update([ //Pass Product id here like show
            'product_id' => $product_id,
            'image_1' => $save_url1,
            'image_2' => $save_url2,
            'image_3' => $save_url3,
            'image_4' => $save_url4,
            'short_description' => $request->short_description,
            'color' => $request->color,
            'size' => $request->size,
            'other_attr' => $request->other_attr,
            'long_description' => $request->long_description,
        ]);

        return redirect()->route('admin.all.product');
    }
}
