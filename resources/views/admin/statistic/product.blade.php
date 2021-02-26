@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Customer', 'item2' => 'Product'])
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
                <h3 class="card-label">Số liệu kinh doanh theo sản phẩm</h3>
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
                                        <select class="form-control" id="kt_select2_1" name="product">
                                            @foreach($products as $productItem)
                                                <option @if($productItem->product_type == $productType){{'selected'}}@endif value="{{$productItem->product_type}}">
                                                    {{$productItem->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class='input-group' id='kt_daterangepicker_6'>
                                        <input type='text' value="{{date('d/m/Y', strtotime($dateStart))}} - {{date('d/m/Y', strtotime($dateEnd))}}" name="date" class="form-control" readonly  placeholder="Chọn thời gian"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                        </div>
                                   </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" name="submit" value="thongke" class="btn btn-light-primary px-6 font-weight-bold">Thống kê</button>
                                    <button class="btn btn-light-success px-6 font-weight-bold" name="submit" type="submit" value="export">Xuất Excel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </form>
            <!--end::Search Form-->
        </div>
        <div class="card-header">
            <table class="table">
                <thead>
                    <tr>
                        <th>Stt</th>
                        <th>Nhân viên</th>
                        <th>Số lượng</th>
                        <th>Đơn giá (đ)</th>
                        <th>Tiền vào (đ)</th>
                        <th>Tiền ra (đ)</th>
                        <th>Chiết khấu</th>
                        <th>Hoa hồng (đ)</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($transactions) > 0)
                        @foreach ($transactions as $key => $item)
                            @php
                                $unitPrice = $item->price; // đơn giá
                                $sl = $item->qty; // số lương
                                $discount = $item->product->discount; // chiết khấu % trên mỗi sp cho nhân viên
                                $price = $sl * $unitPrice; // tổng giá (tiền vào)
                                $unitPriceInput = $item->product->input_price * $sl; // só tiền phải trả cho nhà thầu mỗi đơn hàng
                            @endphp
                            <tr>
                                <td>
                                    {{$key + 1}}
                                </td>
                                <td>
                                    {{!empty($item->user->fullname) ? $item->user->fullname : ''}}
                                </td>
                                <td>
                                    {{$sl}}
                                </td>
                                <td>
                                    {{number_format($unitPrice)}}
                                </td>
                                <td>
                                    {{number_format($price)}}
                                </td>
                                <td>
                                    {{number_format($unitPriceInput)}}
                                </td>
                                <td>
                                    {{$discount}}
                                </td>
                                <td>
                                    {{number_format(($price - $unitPriceInput) * $discount/100)}}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th style="text-align: right" colspan="4">
                            Tổng
                        </th>
                        <th>
                            {{$data['inputPrice']}}
                        </th>
                        <th>
                            {{$data['outputPrice']}}
                        </th>
                        <th></th>
                        <th>
                            {{$data['profit']}}
                        </th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
            <div class="row">
                @if(count($transactions) > 0)
                    {{$transactions->appends(['product' => $productType, 'date' => date('d/m/Y', strtotime($dateStart)) . '-' . date('d/m/Y', strtotime($dateEnd)), 'submit' => 'thongke'])->links()}}
                @endif                
            </div>            
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
<script src="assets/js/pages/crud/forms/widgets/bootstrap-daterangepicker.js"></script>
@endsection