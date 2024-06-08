@extends('admin.admin_master')
@section('admin')
    @php

        $users = \App\Models\User::select('name')
            ->where('id', '=', $goods->user_id)
            ->get();
        foreach ($users as $k => $user) {
            $name = $user->name;
        }

        $customer = \App\Models\Order::join('customers', 'customer_id', '=', 'customers.id')
            ->select('customers.*')
            ->where('cart_id', '=', $goods->id)
            ->get();
        foreach ($customer as $k => $value) {
            $namex = $value->name;
            $addr = $value->address;
            $phone = $value->phone;
            $email = $value->email;
        }

    @endphp
    <form action="" method="post">
        <h6 class="text-light bg-green font-weight-bold p-4">Mã đơn hàng {{ $goods->name_package }} của khách hàng có mã tài
            khoản tên {{ $name }} sẽ được chuyển đi sau khi nhấn xác nhận</h6>
        <p>Tên khách hàng: {{ $namex }}</p>
        <p>Địa chỉ khách hàng: {{ $addr }}</p>
        <p>SĐT khách hàng: {{ $phone }}</p>
        <p>Email khách hàng: {{ $email }}</p>
        <div class="card">
            <div class="card-body">
                @foreach ($products as $pro)
                    <div class="d-flex mb-3">
                        <a href="/san-pham/{{ $pro->id }}-{{ $pro->slug }}.html" class="me-3">
                            <img src="{{ $pro->image }}" style="min-width: 100px; height: 100px;"
                                class="img-md img-thumbnail" />
                        </a>
                        <div class="info">
                            <a href="/san-pham/{{ $pro->id }}-{{ $pro->slug }}.html" class="nav-link mb-1">
                                {{ $pro->name }} <br />
                            </a>
                            <p class="mtext-106 cl2" style=" padding: 0 1rem;text-decoration: line-through; color:red">
                                {{ number_format($pro->price, 0, ',', '.') }} vnđ
                            </p>
                            <p class="text-dark" style="padding: 0 1rem;">{{ number_format($pro->proprice, 0, ',', '.') }}
                                <span>vnđ</span>
                            </p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Xác nhận</button>
        @csrf
    </form>
@endsection
