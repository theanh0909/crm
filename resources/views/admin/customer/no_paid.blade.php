@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Customer', 'item2' => 'Khách hàng chưa thanh toán'])
<div class="container">
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title">
                <span class="card-icon">
                    <span class="svg-icon svg-icon-md svg-icon-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="13" rx="1.5" />
                                <rect fill="#000000" opacity="0.3" x="7" y="9" width="3" height="8" rx="1.5" />
                                <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero" />
                                <rect fill="#000000" opacity="0.3" x="17" y="11" width="3" height="6" rx="1.5" />
                            </g>
                        </svg>
                    </span>
                </span>
                <h3 class="card-label">Khách hàng chưa thanh toán</h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-body">
            <form method="GET">
                <div class="mt-2 mb-7">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-4 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <input  type="text" name="name" class="form-control" placeholder="Nhập từ khóa" value="{{$name}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-light-primary px-6 font-weight-bold">Tìm kiếm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-header">
            <table class="table">
                <thead>
                    <tr align="center">
                        <th scope="col">STT</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Phụ trách</th>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Đã trả</th>
                        <th scope="col">Còn thiếu</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $key => $saleItem)
                        @if(auth()->user()->level > 0 || $saleItem->user_id == auth()->user()->id)
                            <tr>
                                <td>
                                    {{$key+1}}
                                </td>
                                <td>
                                    <p>
                                        <i style="margin-right: 5px" class="flaticon2-user"></i>{{$saleItem->customer_name}}
                                    </p>
                                    <p>
                                        <i style="margin-right: 5px" class="flaticon2-phone"></i>{{$saleItem->customer_phone}}
                                    </p>
                                </td>
                                <td>{{$saleItem->user->fullname}}</td>
                                <td>
                                @foreach($saleItem->saleDetail as $product)
                                    <p>
                                        - {{\App\Helpers\Helper::getProductName($product->product)->name}}
                                    </p>
                                    @endforeach
                                </td>
                                <td>
                                    {{number_format($saleItem->total)}}
                                </td>
                                <td>
                                    {{number_format($saleItem->prepaid)}}
                                </td>
                                <td>
                                    {{number_format($saleItem->total - $saleItem->prepaid)}}
                                </td>
                                <td>
                                    @if($saleItem->status_prepaid == 0)
                                        <span class="label label-lg label-light-success label-inline">Đã thanh toán</span>
                                    @elseif($saleItem->status_prepaid == 1)
                                        <span class="label label-lg label-light-danger label-inline">Còn nợ</span>
                                    @elseif($saleItem->status_prepaid == 2)
                                        <span class="label label-lg label-light-warning label-inline">Sếp chưa duyệt</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($saleItem->status_prepaid != 0)
                                        @if(auth()->user()->level == 1)
                                            <a onclick="confirm('Bạn có chắc chắn xác nhận?')" href="{{route('admin.customer.confirm-pay', ['id' => $saleItem->id])}}" class="btn btn-success">
                                                Xác nhận
                                            </a>
                                        @else
                                            @if($saleItem->status_prepaid == 2)
                                                <i>Đợi sếp duyệt</i>
                                            @else
                                                <a href="{{route('admin.customer.confirm-pay', ['id' => $saleItem->id])}}" class="btn btn-danger">
                                                    Đã thanh toán
                                                </a>
                                            @endif
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                {{$sales->links()}}
            </div>
        </div>
    </div>
</div>
@endsection