<?php

namespace App\Http\Services\Product;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{

    public function getAll()
    {
        return Product::orderby('id')->paginate(16);
    }

    //insert toàn bộ thông tin vào database
    public function create($request)
    {
        try {
            Product::create([
                'name' => (string) $request->input('name'),
                'menu_id' => (int) $request->input('menu_id'),
                'price' => (int) $request->input('price'),
                'quantity' => (int) $request->input('quantity'),
                'price_sale' => (int) $request->input('price_sale'),
                'description' => (string) $request->input('description'),
                'content' => (string) $request->input('content'),
                'image' => (string) $request->input('thumb'),
                'active' => (string) $request->input('active'),
                'slug' => Str::slug($request->input('name'), '-')
            ]);


            Session::flash('success', 'Tạo sản phẩm thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Tạo sản phẩm không thành công');
            return false;
        }
        return true;
    }

    public function update($request, $product)
    {
        try {
            $product->name = (string) $request->input('name');
            $product->menu_id = (int) $request->input('menu_id');
            $product->price = (int) $request->input('price');
            $product->price_sale = (int) $request->input('price_sale');
            $product->quantity = (int) $request->input('quantity');
            $product->description = (string) $request->input('description');
            $product->content = (string) $request->input('content');
            $product->image = (string) $request->input('thumb');
            $product->active = (string) $request->input('active');
            $product->update();
            Session::flash('success', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật sản phẩm không thành công');
            return false;
        }
        return true;
    }
    public function destroy($request)
    {
        $product = Product::where('id', $request->input('id'))->first();
        if ($product) {
            $path = str_replace('storage', 'public', $product->image);
            Storage::delete($path);
            $product->delete();
            return true;
        }

        return false;
    }
}
