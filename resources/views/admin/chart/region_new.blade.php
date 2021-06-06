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
				<h3 class="card-label">Thống kê theo khu vực</h3>
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
										<select class="form-control" id="kt_select2_1" name="region">
											@foreach ($regions as $regionItem)
												<option @if(!isset($inputs['region']) && $regionItem->customer_cty == 'Hà Nội'){{'selected'}}@elseif(isset($inputs['region']) && $inputs['region'] == $regionItem->customer_cty){{'selected'}}@endif value="{{$regionItem->customer_cty}}">{{$regionItem->customer_cty}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-3 my-2 my-md-0">
									<div class="d-flex align-items-center">
										<select class="form-control" id="kt_select2_2" name="product">
											<option value="-1">Tất cả phần mềm</option>
											@foreach ($productions as $productItem)
												<option @if(isset($inputs['product']) && $productItem->product_type == $inputs['product']){{'selected'}}@endif value="{{$productItem->product_type}}">{{$productItem->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<button type="submit" name="submit" value="thongke" class="btn btn-light-primary px-6 font-weight-bold">Thống kê</button>
								</div>
							</div>
						</div>
					</div>

				</div>
			</form>
			<!--end::Search Form-->
		</div>
		<div class="card-header">
			<h3>
				Khu vực {{isset($inputs['region']) ? $inputs['region'] : 'Hà Nội'}}
			</h3>
			<table class="table">
				<thead>
					<tr>
						<th scope="col">Stt</th>
						<th scope="col">Phần mềm</th>
						<th scope="col">Số lượng</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($products as $key => $productItem)
						<tr>
							<td>{{$key + 1}}</td>
							<td>
								{{$productItem->name}}
							</td>
							<td>
								{{$productItem->registered_count}}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>       
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="/assets/js/pages/crud/forms/widgets/select2.js"></script>
<script src="/assets/js/pages/crud/forms/widgets/bootstrap-daterangepicker.js"></script>
@endsection