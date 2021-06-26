<!DOCTYPE html>
<html lang="vi">
	<!--begin::Head-->
	<head>
		<meta charset="utf-8" />
		<title>GXD CRM</title>
		<base href="{{asset('')}}">
		<meta name="description" content="Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		@yield('css')
		<!--begin::Page Vendors Styles(used by this page)-->
		<link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="images/DutoanGXD.ico" />
		<link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Main-->
		<!--begin::Header Mobile-->
		<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
			<!--begin::Logo-->
			<a href="/">
				<img alt="Logo" src="images/logo.png" width="100px"/>
			</a>
			<!--end::Logo-->
			<!--begin::Toolbar-->
			<div class="d-flex align-items-center">
				<!--begin::Aside Mobile Toggle-->
				<button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
					<span></span>
				</button>
				<!--end::Aside Mobile Toggle-->
				<!--begin::Header Menu Mobile Toggle-->
				<button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
					<span></span>
				</button>
				<!--end::Header Menu Mobile Toggle-->
				<!--begin::Topbar Mobile Toggle-->
				<button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
				</button>
				<!--end::Topbar Mobile Toggle-->
			</div>
			<!--end::Toolbar-->
		</div>
		<!--end::Header Mobile-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">
				<!--begin::Aside-->
				<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
					<!--begin::Brand-->
					<div class="brand flex-column-auto" id="kt_brand">
						<!--begin::Logo-->
						<a href="/" class="brand-logo">
							<img alt="Logo" src="images/logo.png" style="max-width: 100%"/>
						</a>
						<!--end::Logo-->
						<!--begin::Toggle-->
						<button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
							<span class="svg-icon svg-icon svg-icon-xl">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
										<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
									</g>
								</svg>
								<!--end::Svg Icon-->
							</span>
						</button>
						<!--end::Toolbar-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside Menu-->
					<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
						<!--begin::Menu Container-->
						<div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
							<!--begin::Menu Nav-->
							<ul class="menu-nav">
								<li class="menu-item menu-item-active" aria-haspopup="true">
									<a href="" class="menu-link">
										<span class="svg-icon menu-icon">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
											<i class="flaticon-home-2"></i>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-text">Trang chủ</span>
									</a>
								</li>
								<li class="menu-section">
									<h4 class="menu-text">Quản lý</h4>
									<i class="menu-icon ki ki-bold-more-hor icon-md"></i>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="{{route('admin.request.create')}}" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<i class="flaticon2-paper-plane"></i>
										</span>
										<span class="menu-text">Yêu cầu gửi key</span>
									</a>
								</li>
								@if(can('license-sendkey'))
									<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
										<a href="{{route('admin.license.not-actived', ['product_type' => 'DutoanGXD2020'])}}" class="menu-link menu-toggle">
											<span class="svg-icon menu-icon">
												<i class="flaticon-email-black-circular-button"></i>
											</span>
											<span class="menu-text">Nhập Email gửi key</span>
										</a>
									</li>
								@endif
								@if(can('license-approved'))
									<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
										<a href="{{route('admin.request.index')}}" class="menu-link menu-toggle">
											<span class="svg-icon menu-icon">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
												<i class="flaticon2-accept"></i>
												<!--end::Svg Icon-->
											</span>
											<span class="menu-text">Duyệt đơn hàng</span>
										</a>
									</li>
								@endif
								@if(can('approve-registered'))
									<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
										<a href="{{route('admin.customer.list-registered-edit')}}" class="menu-link menu-toggle">
											<span class="svg-icon menu-icon">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
												<i class="flaticon2-accept"></i>
												<!--end::Svg Icon-->
											</span>
											<span class="menu-text">Duyệt đơn hàng sửa</span>
										</a>
									</li>
								@endif
								</li><li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="{{route('admin.request.myRequest')}}" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<i class="flaticon2-poll-symbol"></i>
										</span>
										<span class="menu-text">Theo dõi yêu cầu</span>
									</a>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<i class="flaticon-medal"></i>
										</span>
										<span class="menu-text">Thi chứng chỉ</span>
										<i class="menu-arrow"></i>
									</a>
									<div class="menu-submenu">
										<i class="menu-arrow"></i>
										<ul class="menu-subnav">
											
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.customer.certificate-list-approve')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Đợi duyệt</span>
												</a>
											</li>
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.certificate.list-certificate')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Đã duyệt</span>
												</a>
											</li>
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.certificate.contest-list')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Dự thi</span>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<i class="flaticon-chat"></i>
										</span>
										<span class="menu-text">Chăm sóc khách hàng</span>
										<i class="menu-arrow"></i>
									</a>
									<div class="menu-submenu">
										<i class="menu-arrow"></i>
										<ul class="menu-subnav">
											
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.customer.not-actived')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Khách chưa kích hoạt</span>
												</a>
											</li>
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.chart.expiredBeforeCustomer')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Khách sắp hết hạn</span>
												</a>
											</li>
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.chart.expiredCustomer')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Khách đã hết hạn</span>
												</a>
											</li>
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.customer.classify')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Phân loại khách hàng</span>
												</a>
											</li>
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.customer.today')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Sử dụng trong ngày</span>
												</a>
											</li>
											@if(can('statistic-region'))
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.chart.region')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Biểu đồ khu vực</span>
													</a>
												</li>
											@endif
											@if(can('statistic-user'))
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.chart.user')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Thống kê nhân viên</span>
													</a>
												</li>
											@endif
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.chart.courseLicense')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Key tặng kèm</span>
												</a>
											</li>
										</ul>
									</div>
								</li>
								@if(can(['license-create', 'license-view'], true))
									<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
										<a href="javascript:;" class="menu-link menu-toggle">
											<span class="svg-icon menu-icon">
												<i class="flaticon2-lock"></i>
											</span>
											<span class="menu-text">Thông tin key</span>
											<i class="menu-arrow"></i>
										</a>
										<div class="menu-submenu">
											<i class="menu-arrow"></i>
											<ul class="menu-subnav">
												@if(can('license-view'))
													<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
														<a href="{{route('admin.license.not-actived', ['product_type' => 'DutoanGXD2020'])}}" class="menu-link menu-toggle">
															<i class="menu-bullet menu-bullet-dot">
																<span></span>
															</i>
															<span class="menu-text">Key chờ gửi đi</span>
														</a>
													</li>
													<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
														<a href="{{route('admin.license.emailSendedToday')}}" class="menu-link menu-toggle">
															<i class="menu-bullet menu-bullet-dot">
																<span></span>
															</i>
															<span class="menu-text">Key gửi đi trong ngày</span>
														</a>
													</li>
													<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
														<a href="{{route('admin.license.emailSended')}}" class="menu-link menu-toggle">
															<i class="menu-bullet menu-bullet-dot">
																<span></span>
															</i>
															<span class="menu-text">Key đã gửi qua Email</span>
														</a>
													</li>
													<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
														<a href="{{route('admin.customer.index')}}" class="menu-link menu-toggle">
															<i class="menu-bullet menu-bullet-dot">
																<span></span>
															</i>
															<span class="menu-text">Key đã kích hoạt</span>
														</a>
													</li>
													<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
														<a href="{{route('admin.license.exported')}}" class="menu-link menu-toggle">
															<i class="menu-bullet menu-bullet-dot">
																<span></span>
															</i>
															<span class="menu-text">Key đã xuất Excel</span>
														</a>
													</li>
													<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
														<a href="{{route('admin.license.exportApi')}}" class="menu-link menu-toggle">
															<i class="menu-bullet menu-bullet-dot">
																<span></span>
															</i>
															<span class="menu-text">Key đã xuất ra API</span>
														</a>
													</li>
													@endif
												@if(can('license-create'))
													<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
														<a href="{{route('admin.license.create')}}" class="menu-link menu-toggle">
															<i class="menu-bullet menu-bullet-dot">
																<span></span>
															</i>
															<span class="menu-text">Tạo mới</span>
														</a>
													</li>
													<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
														<a href="{{route('admin.license.key-store')}}" class="menu-link menu-toggle">
															<i class="menu-bullet menu-bullet-dot">
																<span></span>
															</i>
															<span class="menu-text">Kho key</span>
														</a>
													</li>
												@endif
											</ul>
										</div>
									</li>
								@endif
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<i class="flaticon-users-1"></i>
										</span>
										<span class="menu-text">Danh sách khách hàng</span>
										<i class="menu-arrow"></i>
									</a>
									<div class="menu-submenu">
										<i class="menu-arrow"></i>
										<ul class="menu-subnav">
											
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.customer.listHashKeyCustomer')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Sử dụng khóa cứng</span>
												</a>
											</li>
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.customer.index')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Sử dụng khóa mềm</span>
												</a>
											</li>
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.course.index')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Tham gia khóa học</span>
												</a>
											</li>
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.certification')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Dự thi chứng chỉ</span>
												</a>
											</li>
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.chart.region')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Theo khu vực </span>
												</a>
											</li>
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.customer.trial')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Khách dùng thử</span>
												</a>
											</li>
											@if(can('customer-feedback'))
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.feedback.index')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Khách góp ý</span>
												</a>
											</li>
											@endif
										</ul>
									</div>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<i class="flaticon-pie-chart-1"></i>
										</span>
										<span class="menu-text">Số liệu kinh doanh</span>
										<i class="menu-arrow"></i>
									</a>
									<div class="menu-submenu">
										<i class="menu-arrow"></i>
										<ul class="menu-subnav">
											
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.customer.no-paid')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Chưa thanh toán</span>
												</a>
											</li>
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.statistic.usersDetail')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Chi tiết nhân viên</span>
												</a>
											</li>
											@if(can('statistic'))
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.statistic.consolidated')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Tổng hợp nhân viên</span>
													</a>
												</li>
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.statistic.vacc')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Phải trả cho VACC</span>
													</a>
												</li>
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.statistic.vace')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Phải trả cho VACE</span>
													</a>
												</li>
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.statistic.product')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Theo sản phẩm</span>
													</a>
												</li>
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.statistic.time')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Theo thời gian</span>
													</a>
												</li>
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.statistic.local')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Theo địa phương</span>
													</a>
												</li>
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.chart.kpi')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Số liệu KPI</span>
													</a>
												</li>
											@endif
										</ul>
									</div>
								</li>
								<li class="menu-section">
									<h4 class="menu-text">Quản trị</h4>
									<i class="menu-icon ki ki-bold-more-hor icon-md"></i>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<i class="flaticon2-user"></i>
										</span>
										<span class="menu-text">Người dùng và quyền</span>
										<i class="menu-arrow"></i>
									</a>
									<div class="menu-submenu">
										<i class="menu-arrow"></i>
										<ul class="menu-subnav">
											@if(can('system-user'))
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.user.index')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Danh sách người dùng</span>
													</a>
												</li>
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.roles.index')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Nhóm phân quyền</span>
													</a>
												</li>
											@endif
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="{{route('admin.user.reset-password')}}" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Đổi password</span>
												</a>
											</li>
											@if(can('create-permission'))
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.permission.index')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Quyền truy cập</span>
													</a>
												</li>
											@endif
										</ul>
									</div>
								</li>
								@if(can(['system-emailtemplate', 'system-email'], true))
									<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
										<a href="javascript:;" class="menu-link menu-toggle">
											<span class="svg-icon menu-icon">
												<i class="flaticon2-email"></i>
											</span>
											<span class="menu-text">Email</span>
											<i class="menu-arrow"></i>
										</a>
										<div class="menu-submenu">
											<i class="menu-arrow"></i>
											<ul class="menu-subnav">
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.email.form-create')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Soạn mẫu mail</span>
													</a>
												</li>
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.email.index')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Sản phẩm</span>
													</a>
												</li>
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.mailcontent.list')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Cài đặt Email hệ thống</span>
													</a>
												</li>
												<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
													<a href="{{route('admin.settings.email')}}" class="menu-link menu-toggle">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">Cấu hình Email</span>
													</a>
												</li>
												
											</ul>
										</div>
									</li>
								@endif
								@if(can(['system-system', 'system-product'], true))
									<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
										<a href="javascript:;" class="menu-link menu-toggle">
											<span class="svg-icon menu-icon">
												<i class="flaticon2-settings"></i>
											</span>
											<span class="menu-text">Hệ thống</span>
											<i class="menu-arrow"></i>
										</a>
										<div class="menu-submenu">
											<i class="menu-arrow"></i>
											<ul class="menu-subnav">
												@if(can('system-product'))
													<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
														<a href="{{route('admin.product.index')}}" class="menu-link menu-toggle">
															<i class="menu-bullet menu-bullet-dot">
																<span></span>
															</i>
															<span class="menu-text">Sản phẩm</span>
														</a>
													</li>
												@endif
												@if(can('system-system'))
													<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
														<a href="{{route('admin.settings.system')}}" class="menu-link menu-toggle">
															<i class="menu-bullet menu-bullet-dot">
																<span></span>
															</i>
															<span class="menu-text">Cấu hình hệ thống</span>
														</a>
													</li>
													<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
														<a href="{{route('admin.settings.api')}}" class="menu-link menu-toggle">
															<i class="menu-bullet menu-bullet-dot">
																<span></span>
															</i>
															<span class="menu-text">Cấu hình API</span>
														</a>
													</li>
													<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
														<a href="{{route('admin.backup.index')}}" class="menu-link menu-toggle">
															<i class="menu-bullet menu-bullet-dot">
																<span></span>
															</i>
															<span class="menu-text">Sao lưu dữ liệu</span>
														</a>
													</li>
												@endif
											</ul>
										</div>
									</li>
								@endif
							</ul>
							<!--end::Menu Nav-->
						</div>
						<!--end::Menu Container-->
					</div>
					<!--end::Aside Menu-->
				</div>
				<!--end::Aside-->