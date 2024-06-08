<?php


namespace App\Http\Services;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Package;
use App\Models\PackagesProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartService
{
    public function create($request)
    {
        $quantity = (int)$request->input('num_product'); //Lấy ra thông tin số lượng được nhập vào
        $product_id = (int)$request->input('product_id'); //Lấy ra thông tin id được nhập vào
        $product = [
            $product_id => $quantity,
        ];
        if ($quantity <= 0 || $product_id <= 0) {
            Session::flash('error', 'Số lượng hoặc Sản phẩm không chính xác');
            return false;
        }
        //Kiểm tra
        $carts = Session::get('carts', []); // Trả về arr
        $idCart = (int)$request->input('cart_id');
        if (is_null($carts)) {
            Session::put('carts', [ //Tạo ra giỏ hàng
                'cart_id' => $idCart,
                $product_id => $quantity
            ]);
            return true;
        }
        //Kiểm tra sản phẩm có trong giỏ hàng hay chưa -> update
        //dd(session()->get('carts'));
        $carts[$idCart][$product_id] = $quantity;
        Session::put('carts', $carts);
        return true;
    }

    public function getProduct()
    {
        // $carts = Session::get('carts');
        // if (is_null($carts)) return [];

        // $idcart = array_keys($carts);
        // $productId =array_keys($carts[$idcart]);
        // return Product::select('id', 'name', 'price', 'price_sale', 'image')
        //     ->where('active', 1)
        //     ->whereIn('id', $productId)
        //     ->get();
        $carts = Session::get('carts');
        if (is_null($carts)) return [];

        $products = collect();
        foreach ($carts as $idcart => $cart) {
            $productId = array_keys($cart);
            $products = $products->merge(Product::select('id', 'title', 'price', 'price_sale', 'image')
                ->where('active', 1)
                ->whereIn('id', $productId)
                ->get());
        }
        return $products;
    }

    // public function update($request)
    // {

    //     Session::put('carts', $request->input('num_product'));

    //     return true;
    // }

    public function remove($cart_ID, $id)
    {
        $carts = Session::get('carts');
        unset($carts[$cart_ID][$id]);
        if (empty($carts[$cart_ID])) {
            unset($carts[$cart_ID]);
        }

        Session::put('carts', $carts);
        return true;
    }

    // public function addCart($request)
    // {
    //     try {
    //         DB::beginTransaction();

    //         $carts = Session::get('carts');

    //         if (is_null($carts))
    //             return false;

    //         $customer = Customer::create([
    //             'name' => $request->input('name'),
    //             'phone' => $request->input('phone'),
    //             'address' => $request->input('address'),
    //             'email' => $request->input('email'),
    //             'content' => $request->input('content')
    //         ]);

    //         $this->infoProductCart($carts, $customer->id);

    //         DB::commit();
    //         Session::flash('success', 'Đặt Hàng Thành Công');

    //         #Queue
    //         //SendMail::dispatch($request->input('email'))->delay(now()->addSeconds(2));

    //         Session::forget('carts');
    //     } catch (\Exception $err) {
    //         DB::rollBack();
    //         Session::flash('error', 'Đặt Hàng Lỗi, Vui lòng thử lại sau');
    //         return false;
    //     }

    //     return true;
    // }

    // protected function infoProductCart($carts, $customer_id)
    // {
    //     $productId = array_keys($carts);
    //     dd($productId);
    //     $products = Product::select('id', 'name', 'price', 'price_sale', 'image')
    //         ->where('active', 1)
    //         ->whereIn('id', $productId)
    //         ->get();

    //     $data = [];
    //     foreach ($products as $product) {
    //         $data[] = [
    //             'customer_id' => $customer_id,
    //             'product_id' => $product->id,
    //             'pty'   => (int)$carts[$product->id],
    //             'price' => $product->price_sale != 0 ?  $product->price - (($product->price * $product->price_sale) / 100) : $product->price
    //         ];
    //     }

    //     return Order::insert($data);
    // }

    public function addCart_id($request, $id)
    {
        try {
            DB::beginTransaction();

            $carts = Session::get('carts');
            $cart_id = (int)$id;

            $rq = $request;

            $randomString = Str::random(10);

            $userId = Session::get('user_id');

            $date = $request->input('date');
            $day = Carbon::parse($date)->format('d');

            if (is_null($carts))
                return false;
            $countCart = DB::table('packages')->where('user_id', $userId)->count();
            $newPackage = $countCart + 1;
            $y_no = 1;
            $subCart = Package::create([
                'user_id' => $userId,
                'package_num_us' => $newPackage,
                'name' => 'PK_' . $randomString,
                'status' => 1,
                'day_order' => $day,
                'quantity' => 0,
                'y_no' => $y_no,
                'distance' => (int) $request->input('distance'),
            ]);

            $customer = Customer::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
            ]);

            $this->infoProductCart($rq, $carts[$cart_id], $subCart->id);

            $this->infoCart($customer->id, $userId, $subCart->id);


            DB::commit();

            #Queue
            //SendMail::dispatch($request->input('email'))->delay(now()->addSeconds(2));

            unset($carts[$id]);
            Session::put('carts', $carts);
        } catch (\Exception $err) {
            DB::rollBack();
            return false;
        }

        return true;
    }

    protected function infoCart($customer_id, $userId, $subCart_id)
    {
        $data[] = [
            'cart_id' => $subCart_id,
            'user_id' => $userId,
            'customer_id' => $customer_id,

        ];

        return Order::insert($data);
    }

    protected function infoProductCart($rq, $cart_id, $subCart_id)
    {
        $productId = array_keys($cart_id);


        $products = Product::select('id', 'title', 'price', 'price_sale', 'image')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();

        $data = [];
        foreach ($products as $product) {
            $price = $product->price_sale != 0 ? $product->price - (($product->price_sale * $product->price) / 100) : $product->price;
            $data[] = [
                'package_id' => $subCart_id,
                'product_id' => $product->id,
                'quantity' => $rq->input('num_product.' . $product->id),
                'price' => $rq->input('num_product.' . $product->id) * $price
            ];
        }
        return PackagesProduct::insert($data);
    }


    public function getCustomer()
    {
        return Customer::orderByDesc('id')->paginate(15);
    }

    public function getProductForCart($customer)
    {
        return $customer->carts()->with(['product' => function ($query) {
            $query->select('id', 'title', 'image');
        }])->get();
    }
}
