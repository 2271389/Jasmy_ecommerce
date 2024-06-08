@extends('admin.admin_master')
@section('admin')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card radius-10 bg-gradient-deepblue">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 text-white">9526</h5>
                                <div class="ms-auto">
                                    <i class='bx bx-cart fs-3 text-white'></i>
                                </div>
                            </div>
                            <div class="progress my-3 bg-light-transparent" style="height:3px;">
                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex align-items-center text-white">
                                <p class="mb-0">Total Orders</p>
                                <p class="mb-0 ms-auto">+4.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 bg-gradient-orange">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 text-white">20.000.000 đ</h5>
                                <div class="ms-auto">
                                    <i class='bx bx-dollar fs-3 text-white'></i>
                                </div>
                            </div>
                            <div class="progress my-3 bg-light-transparent" style="height:3px;">
                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex align-items-center text-white">
                                <p class="mb-0">Total Revenue</p>
                                <p class="mb-0 ms-auto">+1.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 bg-gradient-ohhappiness">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 text-white">6200</h5>
                                <div class="ms-auto">
                                    <i class='bx bx-group fs-3 text-white'></i>
                                </div>
                            </div>
                            <div class="progress my-3 bg-light-transparent" style="height:3px;">
                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex align-items-center text-white">
                                <p class="mb-0">Visitors</p>
                                <p class="mb-0 ms-auto">+5.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 bg-gradient-ibiza">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 text-white">5630</h5>
                                <div class="ms-auto">
                                    <i class='bx bx-envelope fs-3 text-white'></i>
                                </div>
                            </div>
                            <div class="progress my-3 bg-light-transparent" style="height:3px;">
                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex align-items-center text-white">
                                <p class="mb-0">Messages</p>
                                <p class="mb-0 ms-auto">+2.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->




            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="mb-0">Orders Summary</h5>
                        </div>
                        <div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i>
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order id</th>
                                    <th>Product</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#231001</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="recent-product-img">
                                                <img src="{{ asset('backend/assets/images/icons/01.png') }}" alt="">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-1 font-14">Lifebouy</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Nguyễn Hữu Phước</td>
                                    <td>12 Jul 2023</td>
                                    <td>20.000 đ</td>
                                    <td>
                                        <div class="badge rounded-pill bg-light-info text-info w-100">In Progress</div>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions"> <a href="javascript:;" class=""><i
                                                    class="bx bx-cog"></i></a>
                                            <a href="javascript:;" class="ms-4"><i class="bx bx-down-arrow-alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#231002</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="recent-product-img">
                                                <img src="{{ asset('backend/assets/images/icons/02.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-1 font-14">Purite</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Trịnh Thanh Tâm</td>
                                    <td>14 Jul 2023</td>
                                    <td>22.000 đ</td>
                                    <td>
                                        <div class="badge rounded-pill bg-light-success text-success w-100">Completed</div>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions"> <a href="javascript:;" class=""><i
                                                    class="bx bx-cog"></i></a>
                                            <a href="javascript:;" class="ms-4"><i
                                                    class="bx bx-down-arrow-alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#231003</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="recent-product-img">
                                                <img src="{{ asset('backend/assets/images/icons/03.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-1 font-14">Comfort</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Lê Quốc Đông</td>
                                    <td>15 Jul 2023</td>
                                    <td>23.000 đ</td>
                                    <td>
                                        <div class="badge rounded-pill bg-light-danger text-danger w-100">Cancelled</div>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions"> <a href="javascript:;" class=""><i
                                                    class="bx bx-cog"></i></a>
                                            <a href="javascript:;" class="ms-4"><i
                                                    class="bx bx-down-arrow-alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#231004</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="recent-product-img">
                                                <img src="{{ asset('backend/assets/images/icons/04.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-1 font-14">Downy Xanh Dương</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Tô Thị Ánh Nhàn</td>
                                    <td>18 Jul 2023</td>
                                    <td>25.000 đ</td>
                                    <td>
                                        <div class="badge rounded-pill bg-light-success text-success w-100">Completed</div>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions"> <a href="javascript:;" class=""><i
                                                    class="bx bx-cog"></i></a>
                                            <a href="javascript:;" class="ms-4"><i
                                                    class="bx bx-down-arrow-alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#231005</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="recent-product-img">
                                                <img src="{{ asset('backend/assets/images/icons/05.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-1 font-14">Amity</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Nguyễn Trọng Hiếu</td>
                                    <td>20 Jul 2023</td>
                                    <td>20.000 đ</td>
                                    <td>
                                        <div class="badge rounded-pill bg-light-info text-info w-100">In Progress</div>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions"> <a href="javascript:;" class=""><i
                                                    class="bx bx-cog"></i></a>
                                            <a href="javascript:;" class="ms-4"><i
                                                    class="bx bx-down-arrow-alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#231006</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="recent-product-img">
                                                <img src="{{ asset('backend/assets/images/icons/06.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-1 font-14">Palmolive</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Dương Nguyễn Xuân Nhật</td>
                                    <td>22 Jul 2023</td>
                                    <td>24.000 đ</td>
                                    <td>
                                        <div class="badge rounded-pill bg-light-danger text-danger w-100">Cancelled</div>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions"> <a href="javascript:;" class=""><i
                                                    class="bx bx-cog"></i></a>
                                            <a href="javascript:;" class="ms-4"><i
                                                    class="bx bx-down-arrow-alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
