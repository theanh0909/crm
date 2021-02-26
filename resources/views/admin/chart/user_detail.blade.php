@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Thống kê', 'item2' => 'Thống kê chi tiết bán hàng'])
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
                <h3 class="card-label">
                    Thống kê chi tiết bán hàng
                </h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-body" style="padding-bottom: 0px">
            <form method="GET">
                <div class="mt-2 mb-7">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <select class="form-control select" name="user_id">
                                        <option value="0">Chọn nhân viên</option>
                                        <option value="-1" selected>Tất cả</option>
                                        @foreach($users as $user)
                                            <option @if(request()->get('user_id') == $user->id) selected @endif value="{{$user->id}}">{{$user->fullname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class='input-group' id='kt_daterangepicker_6'>
                                        <input type='text' 
                                            value="@if(!empty($inputs['date']))
                                                {{$inputs['date']}}
                                            @else
                                                {{date('Y-m-d')}}-{{date('Y-m-d')}}
                                            @endif" name="date" class="form-control" readonly  placeholder="Chọn thời gian"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                        </div>
                                   </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary px-6 font-weight-bold"><i class="flaticon-search-magnifier-interface-symbol"></i> Thống kê</button>
                                    <button style="margin-left: 10px" type="submit" class="btn btn-success" name="submit" value="export">
                                        <i class="fa fa-file-excel-o"></i> Xuất Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                        <br>
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
                        @if($userID == -1)
                        <th>Nhân viên</th>
                        @endif
                        <th>Khách hàng</th>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá (đ)</th>
                        <th >Thành tiền (đ)</th>
                        <th>Chiết khấu</th>
                        <th>Hoa hồng (đ)</th>
                        @if(auth()->user()->level > 0)
                            <th>Thao tác</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $totalQty = 0;
                        $totalPrice = 0;
                        $totalDiscount = 0;
                    ?>
                    @foreach($transactions as $item)
                        <?php
                            $price = ($item->price == '') ? 0 : $item->price;
                            $money = $price * $item->qty;
                            
                            if ($item->customer_type == 0) {
                                $discountInt = ( $item->discount != $item->product->discount && $item->discount != 0 ) ? $item->discount : $item->product->discount;

                            } else if ($item->customer_type == 1) {
                                $discountInt = ( $item->discount != $item->product->discount && $item->discount != 0 ) ? $item->discount : $item->product->discount;

                            } else if ($item->customer_type == 2) {
                                $discountInt = ( $item->discount != $item->product->discount && $item->discount != 0 ) ? $item->discount : $item->product->discount;

                            } else if ($item->customer_type == 3) {
                                $discountInt = ( $item->discount != $item->product->discount && $item->discount != 0 ) ? $item->discount : $item->product->discount;

                            }
                            
                            $discount = (($money - $item->product->input_price) * $discountInt) / 100;

                            $totalQty+= $item->qty;
                            $totalPrice+= $money;
                            $totalDiscount += $discount;
                        ?>
                        
                        <tr>
                            <!-- Đánh STT tự động -->
                            <td align="center">{{$loop->index + 1}}</td>
                            @if($userID == -1)
                                <td>
                                    {{$item->user->fullname}}
                                </td>
                            @endif
                            <td>
                                <p>KH: {{$item->customer_name}}</p>
                                <!-- ($customer->product) ? $customer->product->name : '', -->
                                <p>SĐT: {{$item->customer_phone}}</p>
                                <p>Email: {{$item->customer_email}}</p>
                            </td>                     
                            <td>                                
                                <p>Tên SP: {{$item->product->name}}</p>
                                <p>Loại: {{getlabelTypeProduct($item->product->type)}}</p>
                                <p>Tạo đơn: {{date('d/m/Y', strtotime($item->created_at))}}</p>
                                <p>Duyệt đơn: {{date('d/m/Y', strtotime($item->time_approve))}}</p>                                    
                            </td>
                            <td align="center">{{$item->qty}}</td>
                            <td align="center">{{number_format($price, 0, ',', '.')}}</td>
                            
                            <td align="center">{{number_format($money, 0, ',', '.')}}</td>
                            
                            <td align="center">{{$item->product->discount}}%</td>
                            
                            <td align="center">{{number_format($discount, 0, ',', '.')}}</td>
                            @if(auth()->user()->level > 0)
                            <td>
                                <a href="{{route('admin.input-edit-form', ['id' => $item->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                                <a onclick="return deleteQuestion()" href="{{route('admin.chart.usersDetail-delete', ['id' => $item->id])}}" class="btn btn-outline-danger"><i class="fa fa-remove mr-1"></i></a>
                            </td>
                            @endif
                            <script>
                                function deleteQuestion()
                                {
                                    if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')) {
                                        return true;
                                    }

                                    return false;
                                }
                            </script>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <th></th>
                    <th>Tổng cộng:</th>
                    <th></th>
                 
                    <td align="center">{{$totalQty}}</td>  <!-- Số lượng -->
                    <th></th>
                    <td align="center">{{number_format($totalPrice, 0, ',', '.')}}</td> <!-- Doanh thu -->
                    <th></th>
                    <td align="center">{{number_format($totalDiscount, 0, ',', '.')}}</td> <!-- Tổng Hoa hồng -->
                    <th></th>
                </tfoot>
            </table>
        </div>
    </div>
    <br>
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
                <h3 class="card-label">
                    Tổng hợp kết quả
                </h3>
            </div>
        </div>
        <div class="card-header">
            <table class="table">
                <thead>
                <tr align="center">
                    <th>Stt</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá (đ)</th>
                    <th>Thành tiền (đ)</th>
                    <th>% HH</th>
                    <th>Hoa hồng (đ)</th>
                </tr>
                </thead>
                <tbody>
                    @php $tong = 0; @endphp
                    @php $tong2 = 0; @endphp
                    @foreach($transactionsTotal as $key => $transactionsTotalItem)
                        @php
                            $sl = count($transactionsTotalItem);
                            $price = \App\Helpers\Helper::getProductName($key)->price;
                            $discount = \App\Helpers\Helper::getProductName($key)->discount;
                        @endphp
                        <tr>
                            <td align="center">
                                {{++$stt}}
                            </td>
                            <td>
                                {{\App\Helpers\Helper::getProductName($key)->name}}
                            </td>
                            <td align="center">
                                {{$sl}}
                            </td>
                            <td style="text-align: right">
                                {{number_format($price)}}
                            </td>
                            <td style="text-align: center">
                                {{number_format($sl * $price)}}
                            </td>
                            <td align="center">
                                {{$discount}}
                            </td>
                            <td style="text-align: right">
                                {{number_format($discount/100 * ($sl * $price))}}
                                @php $tong = $tong +  $discount/100 * ($sl * $price); @endphp
                                
                            </td>
                            
                        </tr>
                        @php $tong2 = $tong2 +  ($sl * $price); @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Tổng cộng:</th>
                        <th></th>
                        <th></th>
                        <td style="text-align: center">
                            {{number_format($tong2)}}
                        </td>
                        <td></td>
                        <td style="text-align: right">
                            {{number_format($tong)}}
                        </td>
                    </tr>

                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="assets/js/pages/crud/forms/widgets/bootstrap-daterangepicker.js"></script>
<script type="text/javascript">
    $('.select').select2();
</script>
@endsection