@extends('admin.admin_master')
@section('admin')
    <table class="table">
        <tr>
            <th>ID</th>
            <th>User_ID</th>
            <th>User Name</th>
            <th>Name Package</th>
            <th>Price</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            {!! \App\Helpers\helper::goods($goods) !!}
        </tr>
    </table>
@endsection
