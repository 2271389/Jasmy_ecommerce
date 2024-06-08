<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        //Gửi thông tin qua service để tính toán




        $result = $this->cartService->create($request);
        $products = $this->cartService->getProduct();


        if ($result === false) {
            return redirect()->back();
        }
        //return redirect()->back();
        return redirect('/carts');
    }

    public function show()
    {
        $products = $this->cartService->getProduct();

        return view('carts.list', [
            'title' => 'Giỏ Hàng',
            'products' => $products,
            'carts' => Session::get('carts')
        ]);
    }
    public function view($idcart_can_tim = null)
    {
        $products = $this->cartService->getProduct();
        $carts = Session::get('carts');

        if ($idcart_can_tim !== null) {
            foreach ($carts as $idcart => $cart) {
                if ($idcart == $idcart_can_tim) {
                    return view('carts.list', [
                        'title' => 'Giỏ Hàng',
                        'products' => $products,
                        'carts' => [$idcart => $cart],
                        'idcart_can_tim' => $idcart_can_tim
                    ]);
                }
            }
        }

        return view('carts.list', [
            'title' => 'Giỏ Hàng',
            'products' => $products,
            'carts' => $carts
        ])->with('idcart_can_tim', $idcart_can_tim ?? null);
    }



    public function remove($cartID = 0, $id = 0)
    {
        $this->cartService->remove($cartID, $id);

        return redirect('/carts');
    }



    public function addCartId(Request $request, $id = null)
    {

        $this->cartService->addCart_id($request, $id);

        return redirect('/carts');
    }
}
