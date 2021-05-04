@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb')
<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<div class="alert alert-success">
					<h3>
						{{number_format($keyActived)}}
					</h3>
					<a>
						Key đã kích hoạt
					</a>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="alert alert-danger">
					<h3>
						{{number_format($keyNotActived)}}
					</h3>
					<a>
						Key chưa kích hoạt
					</a>
				</div>
				
			</div>
			<div class="col-lg-4">
				<div class="alert alert-warning">
					<h3>
						{{number_format($customerCount)}}
					</h3>
					<a>
						Khách hàng sử dụng (Dựa theo Email đăng ký)
					</a>
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
                <h3 class="card-label">Trang chủ</h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        
        <div class="card-header">
            <div class="card card-custom gutter-b" style="width: 100%">
                <div class="card-header card-header-tabs-line" style="padding: 0px">
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-bold nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_4">
                                    <span class="nav-text">Kích hoạt trong ngày</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2_4">
                                    <span class="nav-text">Sắp hết hạn</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2_5">
                                    <span class="nav-text">Đã hết hạn</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body" style="padding: 2rem 0px">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_tab_pane_1_4" role="tabpanel" aria-labelledby="kt_tab_pane_1_4">
                            <table class="table text-nowrap">
								<thead>
									<tr>
										<th>Khách hàng</th>
										<th>Phần mềm</th>
										<th width="200px">Loại Key</th>
										<th>Hết hạn</th>
										<th>Ghi chú</th>
										<th>Hành động</th>
									</tr>
								</thead>
								<tbody>
					                @foreach($newKeys as $key)
									<tr>
					                    <td>
											<p>
					                    		<b>Tên</b>: <a class="text-success-600" href="@if(!empty($key->customer)){{route('admin.user.profile', ['id' => $key->customer->id])}}@else{{'#'}}@endif">{{$key->customer_name}}</a>
					                    	</p>
											<p>
												<b>Email</b>: <a class="text-success-600" href="{{route('admin.customer.edit', ['id' => $key->id])}}">{{ $key->customer_email }}</a>
											</p>
											<p>
												<b>SĐT</b>: <a class="text-success-600" href="{{route('admin.customer.edit', ['id' => $key->id])}}">{{ $key->customer_phone }}</a>
											</p>
											<p>
												<b>Địa chỉ</b>: <span class="text-success-600">{{ $key->customer_address }}</span>
											</p>
										</td>
					                    
					                    <td><span class="text-success-600">{{$key->product->name}}</span></td>
					                    <td>
											<span class="text-success-600">
												@if(!empty($key->license))
													@if($key->license->status == 1)
														<span class="label label-lg label-light-primary label-inline">
															Key thương mại
														</span>
													@elseif($key->license->status == 0)
														<span class="label label-lg label-light-danger label-inline">
															Key dùng thử
														</span>
													@elseif($key->license->status == 2)
														<span class="label label-lg label-light-success label-inline">
															Key lớp học
														</span>
													@endif
												@else
													{{$key->license_original}}
												@endif
											</span>
										</td>
										<td>
											{{date('d/m/Y', strtotime($key->license_expire_date))}}
										</td>
										<td>
											<textarea data-id="{{$key->id}}" data-table="registered" class="form-control noteaction">{{$key->note}}</textarea>
										</td>
										<td>
											<a href="{{route('admin.delete-key', ['id' => $key->id])}}" onclick="return confirm('Xác nhận xóa!')">
												<button class="btn btn-sm btn-danger" type="submit">
													<i class="flaticon2-rubbish-bin-delete-button"></i>
												</button>
											</a>

										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
                        </div>
                        <div class="tab-pane fade" id="kt_tab_pane_2_4" role="tabpanel" aria-labelledby="kt_tab_pane_2_4">
							<form method="GET">
								<div class="row">
									<div class="form-group col-lg-3">
										<input class="form-control" value="{{$day_due}}" name="day_due" type="number" placeholder="Nhập số ngày">
									</div>
									<div class="form-group col-lg-3">
										<button class="btn btn-primary">Lọc</button>
									</div>
								</div>
							</form>
                            <table class="table">
								<thead>
									<tr>
										<th>Khách hàng</th>
										<th>Phần mềm</th>
										<th>Hết hạn</th>
										<th>Ghi chú</th>
										<th>Gửi mail</th>
										<th>Hành động</th>
									</tr>
								</thead>
								<tbody>
					                @foreach($keyDue as $key)
										<tr>

											<td>
												<p>
													<b>Tên</b>: <a class="text-success-600" href="@if(!empty($key->customer)){{route('admin.user.profile', ['id' => $key->customer->id])}}@else{{'#'}}@endif">{{$key->customer_name}}</a>
												</p>
												<p>
													<b>Email</b>: <a class="text-success-600" href="{{route('admin.customer.edit', ['id' => $key->id])}}">{{ $key->customer_email }}</a>
												</p>
												<p>
													<b>SĐT</b>: <a class="text-success-600" href="{{route('admin.customer.edit', ['id' => $key->id])}}">{{ $key->customer_phone }}</a>
												</p>
												<p>
													<b>Địa chỉ</b>: <span class="text-success-600">{{ $key->customer_address }}</span>
												</p>
											</td>
											<td>
												<span class="text-success-600">{{$key->product->name}}</span><br>
												<span class="text-success-600">
													@if(!empty($key->license))
														@if($key->license->status == 1)
															<span class="label label-lg label-light-primary label-inline">
																Key thương mại
															</span>
														@elseif($key->license->status == 0)
															<span class="label label-lg label-light-danger label-inline">
																Key dùng thử
															</span>
														@elseif($key->license->status == 2)
															<span class="label label-lg label-light-success label-inline">
																Key lớp học
															</span>
														@endif
													@else
														{{$key->license_original}}
													@endif
												</span>
											</td>
											<td>
												{{date('d/m/Y', strtotime($key->license_expire_date))}}
											</td>
											<td>
												<textarea data-id="{{$key->id}}" data-table="registered" class="form-control noteaction">{{$key->note}}</textarea>
												<br>
												<p>
													@if($key->status_care == 0)
														<button data-id="{{$key->id}}" data-status="0" type="button" class="btn btn-danger status-care">
															Chưa chăm sóc
														</button>
													@else
														<button data-id="{{$key->id}}" data-status="1" type="button" class="status-care btn btn-primary">
															Đã chăm sóc
														</button>
													@endif
												</p>
											</td>
											<td>
												@if($key->staus_email == 0)
													<span class="label label-lg label-light-danger label-inline">
														Chưa gửi
													</span>
												@else
													<span class="label label-lg label-light-primary label-inline">
														Đã gửi
													</span>
												@endif
											</td>
											<td>
												<a href="{{route('admin.delete-key', ['id' => $key->id])}}" onclick="return confirm('Xác nhận xóa!')">
													<button class="btn btn-sm btn-danger" type="button" data-toggle="tooltip" data-theme="dark" title="Xóa">
														<i class="flaticon2-rubbish-bin-delete-button"></i>
													</button>
												</a>
												<a href="{{route('admin.email.form-send', ['email' => $key->customer_email])}}" target="_blank">
													<button data-toggle="tooltip" data-theme="dark" title="Gửi mail thông báo" class="btn btn-sm btn-primary" type="button">
														<i class="flaticon2-send-1"></i>
													</button>
												</a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
							<div class="row">
								<div class="col-lg-12">
									{{$keyDue->links()}}
								</div>
							</div>
                        </div>
                        
                        <div class="tab-pane fade" id="kt_tab_pane_2_5" role="tabpanel" aria-labelledby="kt_tab_pane_2_5">
							<form method="GET">
								<div class="row">
									<div class="form-group col-lg-3">
										<input class="form-control" value="{{$day_expire}}" name="day_expire" type="number" placeholder="Nhập số ngày">
									</div>
									<div class="form-group col-lg-3">
										<button class="btn btn-primary">Lọc</button>
									</div>
								</div>
							</form>
                            <table class="table">
								<thead>
									<tr>
										<th>Khách hàng</th>
										<th>Phần mềm</th>
										<th width="200px">Loại Key</th>
										<th>Hết hạn</th>
										<th>Ghi chú</th>
										<th>Hoạt động</th>
									</tr>
								</thead>
								<tbody>
					                @foreach($keyExpire as $key)
										<tr>
											<td>
												<p>
													<b>Tên</b>: <a class="text-success-600" href="@if(!empty($key->customer)){{route('admin.user.profile', ['id' => $key->customer->id])}}@else{{'#'}} @endif">{{$key->customer_name}}</a>
												</p>
												<p>
													<b>Email</b>: <a class="text-success-600" href="{{route('admin.customer.edit', ['id' => $key->id])}}">{{ $key->customer_email }}</a>
												</p>
												<p>
													<b>SĐT</b>: <a class="text-success-600" href="{{route('admin.customer.edit', ['id' => $key->id])}}">{{ $key->customer_phone }}</a>
												</p>
												<p>
													<b>Địa chỉ</b>: <span class="text-success-600">{{ $key->customer_address }}</span>
												</p>
											</td>
											<td><span class="text-success-600">{{$key->product->name}}</span></td>
											<td>
												<span class="text-success-600">
													@if(!empty($key->license))
														@if($key->license->status == 1)
															<span class="label label-lg label-light-primary label-inline">
																Key thương mại
															</span>
														@elseif($key->license->status == 0)
															<span class="label label-lg label-light-danger label-inline">
																Key dùng thử
															</span>
														@elseif($key->license->status == 2)
															<span class="label label-lg label-light-success label-inline">
																Key lớp học
															</span>
														@endif
													@else
														{{$key->license_original}}
													@endif
												</span>
												
											</td>
											<td>
												{{date('d/m/Y', strtotime($key->license_expire_date))}}
											</td>
											<td>
												<textarea data-id="{{$key->id}}" data-table="registered" class="form-control noteaction">{{$key->note}}</textarea>
												<br>
												<p>
													@if($key->status_care == 0)
														<button data-id="{{$key->id}}" data-status="0" type="button" class="btn btn-danger status-care">
															Chưa chăm sóc
														</button>
													@else
														<button data-id="{{$key->id}}" data-status="1" type="button" class="status-care btn btn-primary">
															Đã chăm sóc
														</button>
													@endif
												</p>
											</td>
											<td>
												<a href="{{route('admin.delete-key', ['id' => $key->id])}}" onclick="return confirm('Xác nhận xóa!')">
													<button class="btn btn-sm btn-danger" type="submit">
														<i class="flaticon2-rubbish-bin-delete-button"></i>
													</button>
												</a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
							<div class="row">
								<div class="col-lg-12">
									{{$keyExpire->links()}}
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .card.card-custom{
        box-shadow: none;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">
	$('.noteaction').keyup(debounce(function(e){
        var me = $(this);
        var dataPost = {
          id:   me.data('id'),
          note: me.val(),
          table: me.data('table'),
          _token: "{{csrf_token()}}"
        };
       $.ajax({
           url: "{{route('admin.customer.editComment')}}",
           method: 'POST',
           data: dataPost,
           success: function(e) {
           }
       })
    },1000));
    $('.status-care').click(function(){
    	$(this).removeClass();
    	var me = $(this);

    	if (me.data('status') == 0) {
    		$(this).addClass('btn btn-primary');
    		$(this).text('Đã chăm sóc');
    	} else if (me.data('status') == 1) {
    		$(this).addClass('btn btn-danger');
    		$(this).text('Chưa chăm sóc');
    	}
    	var dataPost = {
          id:   me.data('id'),
          status: me.data('status'),
          _token: "{{csrf_token()}}"
        };
        $.ajax({
           url: "{{route('admin.update-status-care')}}",
           method: 'POST',
           data: dataPost,
           success: function(e) {
           		if (e == true) {
           			alert('Cập nhật thành công');
           		} else {
           			alert('Cập nhật thất bại');
           		}
           }
       })
    });
</script>
@endsection