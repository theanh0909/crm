@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Thống kê', 'item2' => 'Chi tiết bán hàng của nhân viên'])
<div class="container">
    <div class="card card-custom">
		<div class="card-header py-3" >
			<div class="card-title" style="display: unset">
                <p><i style="margin-right: 5px" class="flaticon2-user"></i> {{$customer->name}}</p>
                <p><i style="margin-right: 5px" class="flaticon2-new-email"></i> {{$customer->email}}</p>
                <p><i style="margin-right: 5px" class="flaticon2-phone"></i> {{$customer->phone}}</p>
			</div>
		</div>
	</div><br>
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
                    Sản phẩm của <b>{{$customer->name}}</b>
                </h3>
			</div>
		</div>
		@include('admin.layouts.partitals.notify')
		<div class="card-header">
			<table class="table">
				<thead>
					<tr>
						<th scope="col">STT</th>
						<th scope="col">Nhân viên chăm sóc</th>
						<th scope="col">Sản phẩm</th>
						<th scope="col">Loại key</th>
                        <th scope="col">Thời hạn</th>
                        <th scope="col">Thời gian mua</th>
					</tr>
				</thead>
				<tbody>
					@foreach($productUsed as $key => $productItem)
                        <tr>
                            <td>
                                {{$key + 1}}
                            </td>
                            <td>
                                {{$productItem->user->fullname}}{{$productItem->id}}
                            </td>
                            <td>
                                {{$productItem->product->name}}
                            </td>
                            <td>
                                @if($productItem->customer_type == 0)
                                    <span class="label label-lg label-light-primary label-inline">Khóa mềm</span>
                                @endif
                                @if($productItem->customer_type == 1)
                                    <span class="label label-lg label-light-warning label-inline">Khóa cứng</span>
                                @endif
                                @if($productItem->customer_type == 2)
                                    <span class="label label-lg label-light-success label-inline">Khóa học</span>
                                @elseif($productItem->customer_type == 3)
                                    <span class="label label-lg label-light-danger label-inline">Chứng chỉ</span>
                                @endif
                            </td>
                            <td>
                                {{$productItem->number_day}}
                            </td>
                            <td>
                                @if($productItem->time_approve != '')
                                    {{date('d/m/Y', strtotime($productItem->time_approve))}}
                                @endif
                            </td>
                        </tr>
					@endforeach
				</tbody>
			</table>
			<div class="row">
				          
			</div>            
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
<script src="assets/js/pages/crud/forms/widgets/bootstrap-daterangepicker.js"></script>
@endsection