<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
	<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
		<!--begin::Info-->
		<div class="d-flex align-items-center flex-wrap mr-1">
			<!--begin::Page Heading-->
			<div class="d-flex align-items-baseline flex-wrap mr-5">
				<!--begin::Page Title-->
				<h5 class="text-dark font-weight-bold my-1 mr-5">
					<a href="">Trang chủ</a>
				</h5>
				<!--end::Page Title-->
				<!--begin::Breadcrumb-->
				<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
					@if(!empty($item1))
					<li class="breadcrumb-item">
						<a href="{{url()->current()}}" class="text-muted">{{$item1}}</a>
					</li>
					@endif
					@if(!empty($item2))
					<li class="breadcrumb-item">
						<a href="" class="text-muted">{{$item2}}</a>
					</li>
					@endif
				</ul>
				<!--end::Breadcrumb-->
			</div>
			<!--end::Page Heading-->
		</div>
		<!--end::Info-->
		
	</div>
</div>