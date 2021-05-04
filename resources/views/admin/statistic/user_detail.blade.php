@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Thống kê', 'item2' => 'Chi tiết bán hàng của nhân viên'])
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
				<h3 class="card-label">Chi tiết bán hàng của nhân viên</h3>
			</div>
		</div>
		@include('admin.layouts.partitals.notify')
		<div class="card-body">
			<form method="GET">
				<div class="mt-2 mb-7">
					<div class="row align-items-center">
						<div class="col-lg-12 col-xl-12">
							<div class="row align-items-center">
								<div class="col-md-3 my-2 my-md-0">
									<div class="d-flex align-items-center">
										<select class="form-control" id="kt_select2_1" name="product">
											<option value="0">Chọn nhân viên</option>
											<option value="-1" selected>Tất cả</option>
											@foreach($users as $user)
											<option @if(request()->get('user_id') == $user->id) selected @endif value="{{$user->id}}">{{$user->fullname}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-3 my-2 my-md-0">
									<div class="d-flex align-items-center">
										<select class="form-control" id="kt_select2_2" name="customer_type">
											<option @if($customerType == 4){{'selected'}}@endif value="4">Tất cả</option>
											<option @if($customerType == 0){{'selected'}}@endif value="0">Khóa mềm</option>
											<option @if($customerType == 1){{'selected'}}@endif value="1">Khóa cứng</option>
											<option @if($customerType == 3){{'selected'}}@endif value="3">Chứng chỉ</option>
											<option @if($customerType == 2){{'selected'}}@endif value="2">Khóa học</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class='input-group' id='kt_daterangepicker_6'>
										<input type='text' value="{{$date}}" name="date" class="form-control" readonly  placeholder="Chọn thời gian"/>
										<div class="input-group-append">
											<span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<button type="submit" name="submit" value="thongke" class="btn btn-light-primary px-6 font-weight-bold">Thống kê</button>
									@if(can('statistic'))
									<button class="btn btn-light-success px-6 font-weight-bold" name="submit" type="submit" value="export">Xuất Excel</button>
									@endif

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
						<th scope="col">Stt</th>
						@if($userID == -1)
						<th scope="col">NV</th>
						@endif
						<th scope="col">Khách hàng</th>
						<th scope="col">Sản phẩm</th>
						<th scope="col">SL</th>
						<th scope="col">Đơn giá</th>
						<th scope="col">Tiền vào</th>
						<th scope="col">Tiền ra</th>
						<th scope="col">CK</th>
						<th scope="col">HH</th>
						@if(auth()->user()->level > 0)
						<th scope="col">Thao tác</th>
						@endif
					</tr>
				</thead>
				{{-- Chỉ quyền cao nhất là admin hoặc chính user đó mới dk xem số liệu --}}
				@if($userID == auth()->user()->id || auth()->user()->level > 0)
				<tbody>
					<?php
						$totalQty = 0;
					?>
					@foreach($transactions as $item)
					<?php
						$sl = $item->qty;
						$price = ($item->price == '') ? 0 : $item->price;
						$money = $price * $item->qty;
						if (!empty($item->product)) {
							$discount = $item->product->discount;
							$input_price = $item->product->input_price * $sl;
						} else {
							$input_price = 0;
							$discount = 0;
						}
						$profit = (($money - $input_price) * $discount) / 100;

						$totalQty+= $item->qty;
					?>

					<tr>
						<td align="center">{{$loop->index + 1}}</td>
						@if($userID == -1)
						<td>
							{{$item->user_request_id}}
						</td>
						@endif
						<td>
							<p><i style="margin-right: 5px" class="flaticon2-user"></i>{{!empty($item->customer) ? $item->customer->name : $item->customer_name}}</p>
							<p style="display: flex;"><i style="margin-right: 5px" class="flaticon2-new-email"></i>{{!empty($item->customer) ? $item->customer->email : $item->customer_email}}</p>
							<p><i style="margin-right: 5px" class="flaticon2-phone"></i>{{!empty($item->customer) ? $item->customer->phone : $item->customer_phone}}</p>
						</td>                     
						<td>                                
							<p>
								PM: <b>{{(!empty($item->product)) ? $item->product->name : ''}}</b>
							</p>
							<p>
								@if(!empty($item->product))
									@if($item->product->type == 0)
										<span class="label label-lg label-light-primary label-inline">Khóa mềm</span>
									@endif
									@if($item->product->type == 1)
										<span class="label label-lg label-light-warning label-inline">Khóa cứng</span>
									@endif
									@if($item->product->type == 2)
										<span class="label label-lg label-light-success label-inline">Khóa học</span>
									@elseif($item->product->type == 3)
										<span class="label label-lg label-light-danger label-inline">Chứng chỉ</span>
									@endif
								@endif
							</p>
							<p>Tạo: {{date('d/m/Y', strtotime($item->created_at))}}</p>
							<p>Duyệt: {{date('d/m/Y', strtotime($item->time_approve))}}</p>                                    
						</td>
						<td align="center">{{$item->qty}}</td>
						<td align="center">{{number_format($price, 0, ',', '.')}}</td>

						<td align="center">{{number_format($money, 0, ',', '.')}}</td>
						<td>
							{{number_format($input_price, 0, ',', '.')}}
						</td>
						<td align="center">{{$discount}}%</td>

						<td align="center">
							{{number_format($discount/100 * ($item->price - $input_price), 0, ',', '.')}}
						</td>
						@if(auth()->user()->level > 0)
						<td>
							<div class="dropdown">
								<a href="#" class="btn btn-light-primary font-weight-bold dropdown-toggle" data-toggle="dropdown">
									<i class="flaticon2-gear text-primary"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-sm">
									<ul class="navi">
										<li class="navi-item">
											<a href="{{route('admin.input-edit-form', ['id' => $item->id])}}" class="navi-link">
												<span class="navi-icon"><i class="flaticon-edit-1"></i></span>
												<span class="navi-text">Sửa</span>
											</a>
										</li>
										<li class="navi-item">
											<a onclick="return deleteQuestion()" href="{{route('admin.chart.usersDetail-delete', ['id' => $item->id])}}" class="navi-link">
												<span class="navi-icon"><i class="flaticon2-rubbish-bin-delete-button"></i></span>
												<span class="navi-text">Xóa</span>
											</a>
										</li>

									</ul>
								</div>
							</div>
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
					<th colspan="6" style="text-align: right">Tổng cộng:</th>
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
				</tfoot>
				@else
				<tbody>
					<tr>
						<td colspan="10">
							<center>
								<i>
									Bạn chỉ được xe số liệu của mình
								</i>
							</center>
						</td>
					</tr>
				</tbody>
				@endif
			</table>
			<div class="row">
				@if(count($transactions) > 0 && ($userID == auth()->user()->id || auth()->user()->level > 0))
				{{$transactions->appends(['user_id' => $userID, 'date' => $date, 'submit' => 'thongke', 'customer_type' => $customerType])->links()}}
				@endif             
			</div>            
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
				<h3 class="card-label">Tổng hợp kết quả</h3>
			</div>
		</div>
		<div class="card-header">
			<table class="table">
				<thead>
					<tr align="center">
						<th scope="col">Stt</th>
						<th scope="col">Sản phẩm</th>
						<th scope="col">Số lượng</th>
						<th scope="col">Đơn giá (đ)</th>
						<th scope="col">Tiền vào (đ)</th>
						<th scope="col">Tiền ra</th>
						<th scope="col">% HH</th>
						<th scope="col">Hoa hồng (đ)</th>
					</tr>
				</thead>
				@if($userID == auth()->user()->id || auth()->user()->level > 0)
				<tbody>
					@php $tong = 0; @endphp
					@php $tong1 = 0; @endphp
					@php $tong2 = 0; @endphp
					@php $input_price = 0; $price = 0; @endphp;
					@foreach($transactionsTotal as $key => $transactionsTotalItem)
					@php
					$sl = count($transactionsTotalItem);

					if (!empty(\App\Helpers\Helper::getProductName($key))) {
						$input_price = \App\Helpers\Helper::getProductName($key)->input_price;
						$discount = \App\Helpers\Helper::getProductName($key)->discount;
						$price= \App\Helpers\Helper::getProductName($key)->price;
						$name = \App\Helpers\Helper::getProductName($key)->name;
					} else {
						$discount = 0;
						$input_price = 0;
						$price = 0;
						$name = '';
					}
					@endphp
					<tr>
						<td>
							{{++$stt}}
						</td>
						<td>
							{{$name}}
						</td>
						<td>
							{{$sl}}
						</td>
						<td>
							{{number_format($price)}} {{--Giá trị cột Đơn giá bảng Tổng hợp--}}
						</td>
						<td>
							{{number_format($price * $sl)}}
						</td>
						<td>
							{{number_format($input_price * $sl)}} {{--Tiền ra--}}
						</td>
						<td>
							{{$discount}}
						</td>
						<td>
							{{number_format(($price * $sl - $input_price * $sl) * $discount / 100)}}                                        
						</td>
						<tr>
							@php $tong = $tong +  ($sl * ($price - $input_price)) * $discount/100; @endphp {{--Tổng hợp kết quả hoa hồng--}}
						</tr>

					</tr>
					@php $tong2 = $tong2 +  ($sl * $price); @endphp
					@php $tong1 = $tong1 + ($sl * $input_price); @endphp
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<th scope="col" colspan="4">
							Tổng tộng
						</th>
						<th scope="col">
							{{number_format($tong2)}}
						</th>
						<th scope="col">
							{{number_format($tong1)}}
						</th>
						<th scope="col">

						</th>
						<th scope="col">
							{{number_format($tong)}}
						</th>
					</tr>

				</tfoot>
				@else
				<tbody>
					<tr>
						<td colspan="10">
							<center>
								<i>Bạn chỉ được xem số liệu của mình</i>
							</center>
						</td>
					</tr>
				</tbody>
				@endif
			</table>            
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
<script src="assets/js/pages/crud/forms/widgets/bootstrap-daterangepicker.js"></script>
@endsection