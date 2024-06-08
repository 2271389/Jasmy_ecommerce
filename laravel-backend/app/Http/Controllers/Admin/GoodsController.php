<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Goods\GoodsService;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    protected $goods;

    public function __construct(GoodsService $goods)
    {
        $this->goods = $goods;
    }
    public function index()
    {
        return view('backend.goods.goods_list', [
            'title' => 'Danh Sách Đơn Hàng Được Xác Nhận',
            'goods' => $this->goods->getAll()
        ]);
    }
    public function show(Package $goods)
    {
        $products = DB::table('packages')
            ->join('packages_products', 'packages.id', '=', 'packages_products.package_id')
            ->join('products', 'products.id', '=', 'packages_products.product_id')
            ->where('packages.id', $goods->id)
            ->select('products.*', 'packages_products.price as proprice', 'packages.id as packageId')
            ->get();

        return view('backend.goods.goods_edit', [
            'title' => 'Xác nhận sản phẩm: ' . $goods->name_package,
            'goods' => $goods,
            'products' =>  $products,
            'ifgoods' => $this->goods->getGoods()
        ]);
    }
    public function update(Package $goods)
    {
        $this->goods->update($goods);
        return redirect('admin/goods/list');
    }

    public function notification()
    {
        return view('notifications.notification', [
            'title' => 'Thông báo',
            'goods' => $this->goods->getPK()
        ]);
    }

    public function shownotification(Package $goods)
    {
        $userId = Session::get('user_id');
        $packages = DB::table('packages')
            ->join('users', 'users.id', '=', 'packages.user_id')
            ->join('packages_products', 'packages.id', '=', 'packages_products.package_id')
            ->join('products', 'products.id', '=', 'packages_products.product_id')
            ->select(
                DB::raw('SUM(packages_products.price) as total_price')
            )
            ->where('user_id', $userId)
            ->where('packages.id', $goods->id)
            ->get();

        $products = DB::table('packages')
            ->join('packages_products', 'packages.id', '=', 'packages_products.package_id')
            ->join('products', 'products.id', '=', 'packages_products.product_id')
            ->where('packages.id', $goods->id)
            ->select('products.*', 'packages_products.price as proprice', 'packages.id as packageId')
            ->get();

        return view('notifications.edit', [
            'title' => 'Xác nhận sản phẩm: ' . $goods->name_package,
            'goods' => $goods,
            'products' =>  $products,
            'pk' => $packages,
            'ifgoods' => $this->goods->getGoods(),
        ]);
    }

    public function updatenotification(Package $goods)
    {
        $this->goods->updatePK($goods);
        return redirect('/notification');
    }
}
