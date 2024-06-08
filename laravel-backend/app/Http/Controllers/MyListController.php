<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MyListController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');

        $packages = DB::table('packages')
            ->join('users', 'users.id', '=', 'packages.user_id')
            ->join('packages_products', 'packages.id', '=', 'packages_products.subscription_package_id')
            ->join('products', 'products.id', '=', 'packages_products.product_id')
            ->select(
                'packages.*',
                DB::raw('SUM(packages_products.price) as total_price'),
                DB::raw('GROUP_CONCAT(packages_products.qty) as grouped_qty')
            )
            ->where('user_id', $userId)
            ->groupBy(
                'packages.id',
                'users.id',
                'packages.user_id',
                'packages.package_num_us',
                'packages.name_package',
                'packages.status',
                'packages.day_order',
                'packages.distance',
                'packages.qty',
                'packages.y_no',
                'packages.created_at',
                'packages.updated_at'
            )
            ->get();


        // Dùng mảng để lưu trữ thông tin của từng gói hàng đã hiển thị
        $displayedPackages = [];

        // Lọc và lưu trữ thông tin của từng gói hàng
        foreach ($packages as $pk) {
            if (!in_array($pk->id, $displayedPackages)) {
                // Thêm id của gói hàng vào mảng đã hiển thị
                $displayedPackages[] = $pk->id;

                // Đưa thông tin của gói hàng vào mảng mới để hiển thị
                $displayedPackagesInfo[] = $pk;
            }
        }

        return view('packages.mylist', [
            'title' => 'Giỏ hàng của tôi',
            'packages' => $displayedPackagesInfo,
        ]);
    }


    public function show($id)
    {

        $userId = Session::get('user_id');


        // $packages = Package::where('id', $id)->first();


        $packages = DB::table('packages')
            ->join('packages_products', 'packages.id', '=', 'packages_products.subscription_package_id')
            ->join('products', 'products.id', '=', 'packages_products.product_id')
            ->join('orders', 'packages.id', '=', 'orders.cart_id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->select('packages.*', 'customers.name', 'customers.phone', 'customers.address', 'customers.email', 'customers.content')
            ->where('packages.id', $id)
            ->first();

        $products = DB::table('packages')
            ->join('packages_products', 'packages.id', '=', 'packages_products.subscription_package_id')
            ->join('products', 'products.id', '=', 'packages_products.product_id')
            ->where('packages.id', $id)
            ->select('products.*', 'packages_products.price as proprice', 'packages.id as packageId')
            ->get();



        return view('packages.show', [
            'title' => 'Chi tiết gói',
            'pk' => $packages,
            'products' =>  $products
        ]);
    }

    public function update($id, Request $request)
    {
        $date = $request->input('date');
        $day = Carbon::parse($date)->format('d');

        $customerId = DB::table('packages')
            ->join('packages_products', 'packages.id', '=', 'packages_products.subscription_package_id')
            ->join('products', 'products.id', '=', 'packages_products.product_id')
            ->join('orders', 'packages.id', '=', 'orders.cart_id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->select('customers.id')
            ->where('packages.id', $id)
            ->value('customers.id'); // Sử dụng hàm value() để trả về giá trị cụ thể

        $customer = Customer::find($customerId);

        $customer->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
        ]);

        $package = Package::find($id);

        $package->update([
            'day_order' => $day,
            'distance' => (int) $request->input('distance'),
        ]);

        return redirect()->route('mylist');
    }

    public function updatePK($id, Request $request)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json(['message' => 'Package not found'], 404);
        }

        $newStatus = $request->input('status');

        $package->update(['status' => $newStatus]);

        return redirect()->route('mylist');
    }
}
