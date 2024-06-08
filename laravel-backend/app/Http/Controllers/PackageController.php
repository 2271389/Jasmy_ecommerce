<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Services\Product\ProductPageService;
use Illuminate\Support\Facades\Session;

class PackageController extends Controller
{
    public function index()
    {
        //Session::put('id_cart', $cart_id);
        $idCarts = session()->get('idCarts', []);
        $cart_id = count($idCarts) > 0 ? end($idCarts) + 1 : 1; // Thay bằng ID giỏ hàng thực tế
        array_push($idCarts, $cart_id);
        session()->put('idCarts', $idCarts);
        //dd(session()->get('idCarts'));
        return redirect()->back();
    }
}
