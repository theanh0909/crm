@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Request', 'item2' => 'Yêu cầu gửi key'])
<div class="container">
	<!--begin::Card-->
	<div class="card card-custom gutter-b example example-compact">
		<div class="card-header">
			<h3 class="card-title">Thông tin yêu cầu gửi key</h3>
		</div>
		@include('admin.layouts.partitals.notify')
		<!--begin::Form-->
		<form class="form" method="post" action="{{route('admin.request.store')}}">
			@csrf
			<div class="card-body">
				<div class="form-group row">
					<div class="col-lg-4">
						<label>Tên khách hàng:</label>
						<input type="text" name="customer_name" class="form-control" placeholder="Tên khách hàng..." />
						@if($errors->has('customer_name'))
                            <span class="form-text text-muted ">{{$errors->first('customer_name')}}</span>
                        @endif
					</div>
					<div class="col-lg-4">
						<label>Email:</label>
						<input type="email" name="customer_email" class="form-control" placeholder="Nhập Email khách hàng..." />
						@if($errors->has('customer_email'))
                            <span class="form-text text-muted ">{{$errors->first('customer_email')}}</span>
                        @endif
					</div>
					<div class="col-lg-4">
						<label>Số điện thoại khách hàng:</label>
						<input type="text" name="customer_phone" class="form-control" placeholder="Nhập SĐT khách hàng..." />
						@if($errors->has('customer_phone'))
                            <span class="form-text text-muted ">{{$errors->first('customer_phone')}}</span>
                        @endif
					</div>
				</div>
				
				<div class="form-group row">
					<div class="col-lg-4">
						<label>Loại key:</label>
						<div class="radio-inline">
							<label class="radio radio-solid">
								<input type="radio" name="type" checked="checked" value="1" />
								<span></span>Thương mại
							</label>
							<label class="radio radio-solid">
								<input type="radio" name="type" value="0" />
								<span></span>Dùng thử
							</label>
							<label class="radio radio-solid">
								<input type="radio" name="type" value="2" />
								<span></span>Lớp học
							</label>
						</div>
					</div>
					<div class="col-lg-4">
						<label>Số ngày:</label>
						{{Form::select('number_day', $typeExpireDate, 365, ['class' => 'form-control'])}}
					</div>
					<div class="col-lg-4">
						<label>Số lượng key cần gửi:</label>
						<input type="number" class="form-control" value="1" name="qty">
						@if($errors->has('qty'))
                            <span class="form-text text-muted ">{{$errors->first('qty')}}</span>
                        @endif
					</div>
				</div>
				<div class="form-group row">
					<div class="col-lg-12">
						<label>Phần mềm:</label>
						<div class="radio-inline row">
							@php($i = 0)
		                    @foreach($products as $key => $val)
		                        <label class="col-lg-2 radio radio-solid">
									<input type="radio" name="product_type" value="{{$key}}" />
									<span></span>{{$val}}
								</label>
		                        @php($i++)
		                    @endforeach
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-lg-12">
						<label>Ghi chú</label>
						<textarea class="form-control" rows="5" name="note"></textarea>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<div class="row justify-content-center">
					<div class="col-lg-12" style="text-align: center;">
						<button type="submit" class="btn btn-primary mr-2">Gửi yêu cầu</button>
						<button type="reset" class="btn btn-secondary">Reset</button>
					</div>
				</div>
			</div>
		</form>
		<!--end::Form-->
	</div>
	<!--end::Card-->
</div>
@endsection

@section('script')
<script>
    $('input[name=type]').change(function(e) {
        var me = $(this);
        if(me.val() == 0) {
            $('select[name=number_day]').val(7).change();
        }
        if(me.val() == 1) {
            $('select[name=number_day]').val(365).change();
        }
    });
</script>
@endsection