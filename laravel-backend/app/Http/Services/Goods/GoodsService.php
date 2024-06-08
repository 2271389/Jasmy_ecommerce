<?php

namespace App\Http\Services\Goods;

use App\Models\Package;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\DB;

class GoodsService
{

    public function getAll()
    {
        $currentDate = Carbon::now()->format('d');

        return Package::where('y_no', 1)
            ->where('day_order', $currentDate)->get();
    }
    public function getGoods()
    {
        return Package::orderby('id');
    }
    public function update($goods)
    {

        try {
            $goods->y_no = 0;
            $goods->quantity = $goods->quantity + 1;
            $goods->update();
        } catch (\Exception $err) {
            //Session::flash('error', 'Cập nhật sản phẩm không thành công');
            return false;
        }
        return true;
    }

    public function getPK()
    {
        $userId = request()->session()->get('user_id');


        $currentDate = Carbon::now()->format('d');


        $customer = \App\Models\Package::join('users', 'user_id', '=', 'users.id')
            ->select('users.*')->select('packages.*')
            ->where('y_no', 0)
            ->where('user_id', $userId)
            ->where('day_order', $currentDate)
            ->whereRaw('MONTH(DATE_ADD(packages.updated_at, INTERVAL distance MONTH)) = ?', [Carbon::now()->month])

            ->get();

        return $customer;
    }

    public function updatePK($goods)
    {
        try {
            $goods->y_no = 1;

            $goods->update();
        } catch (\Exception $err) {
            //Session::flash('error', 'Cập nhật sản phẩm không thành công');
            return false;
        }
        return true;
    }
}
