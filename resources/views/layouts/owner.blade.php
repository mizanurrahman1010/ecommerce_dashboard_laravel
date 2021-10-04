<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from codervent.com/synadmin/demo/widgets.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Oct 2020 18:47:16 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Ecommerce Owner</title>
	<!--favicon-->
	<link rel="icon" href="{{ asset('css') }}/admin/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
	<link href="{{ asset('css') }}/admin/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	{{-- <link href="{{ asset('css') }}/admin/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" /> --}}
	<link href="{{ asset('css') }}/admin/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<link href="{{ asset('css') }}/select2.min.css" rel="stylesheet" />
	<link href="{{ asset('css') }}/jquery-confirm.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ asset('css') }}/admin/css/pace.min.css" rel="stylesheet" />
	<script src="{{ asset('css') }}/admin/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('css') }}/admin/css/bootstrap.min.css" />
    {{-- tags inputs  --}}
    <link href="{{ asset('css') }}/assets/bootstrap-tagsinput.css" rel="stylesheet" />
	<!-- Icons CSS -->
	<link rel="stylesheet" href="{{ asset('css') }}/admin/css/icons.css" />
	<link rel="stylesheet" href="{{ asset('css') }}/assets/bootstrap-datepicker.min.css" />
	<link rel="stylesheet" href="{{ asset('css') }}/assets/bootstrap-datetimepicker.min.css" />
    {{-- image upload preview --}}
    <link rel="stylesheet" href="{{ asset('css') }}/assets/aksFileUpload.min.css" />

	@yield('css')
	<!-- App CSS -->
	<link rel="stylesheet" href="{{ asset('css') }}/admin/css/app.css" />

    <style>
        .btn-xs{
            padding: 0.25rem 0.5rem;
            font-size: 12px;
        }
    </style>
</head>

<body>
	<!-- wrapper -->
	<div class="wrapper">
		<!--header-->
		<header class="top-header">
			<nav class="navbar navbar-expand">
				<div class="left-topbar d-flex align-items-center">
					<a href="javascript:;" class="toggle-btn">	<i class="bx bx-menu"></i>
					</a>
					<div class="">
						<img src="{{ asset('css') }}/admin/images/logo-img.png" class="logo-icon" alt="">
					</div>
				</div>

				<div class="right-topbar ml-auto">
					<ul class="navbar-nav">
						<li class="nav-item dropdown dropdown-user-profile">
							<a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-toggle="dropdown">
								<div class="media user-box align-items-center">
									<div class="media-body user-info">
										<p class="user-name mb-0">Jessica Doe</p>
										<p class="designattion mb-0 text-dark">Owner</p>
									</div>
									<img src="{{ asset('css') }}/admin/images/avatars/avatar-1.png" class="user-img" alt="user avatar">
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
									{{-- <a class="dropdown-item" href="javascript:;"><i
										class="bx bx-user"></i><span>Profile</span></a>
								<a class="dropdown-item" href="javascript:;"><i
										class="bx bx-cog"></i><span>Settings</span></a>
								<a class="dropdown-item" href="javascript:;"><i
										class="bx bx-tachometer"></i><span>Dashboard</span></a>
								<a class="dropdown-item" href="javascript:;"><i
										class="bx bx-wallet"></i><span>Earnings</span></a>
								<a class="dropdown-item" href="javascript:;"><i
										class="bx bx-cloud-download"></i><span>Downloads</span></a> --}}
								<div class="dropdown-divider mb-0"></div>	<a class="dropdown-item" href="{{route('owner.logout')}}"><i
										class="bx bx-power-off"></i><span>Logout</span></a>
							</div>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<!--end header-->
		<!--page-wrapper-->
		<div class="page-wrapper">
			<!--sidebar-wrapper-->
			<div class="sidebar-wrapper" data-simplebar="true">
				<div class="sidebar-header">
					<a href="javascript:;" class="toggle-btn"> <i class="bx bx-menu"></i>
					</a>
					<div class="">
						<img src="{{ asset('css') }}/admin/images/logo-img-2.png" class="logo-icon-2" alt="" />
					</div>
				</div>
				<!--navigation-->
				<ul class="metismenu" id="menu">
					<li class="menu-label pt-1">Menu List</li>
					<li>
						<a href="{{route('owner.dashboard')}}">
							<div class="parent-icon"><i class="bx bx-ghost"></i>
							</div>
							<div class="menu-title">Dashboard</div>
						</a>
					</li>
					<li>
						<a class="has-arrow" href="javascript:;">
							<div class="parent-icon"><i class="bx bx-spa"></i>
							</div>
							<div class="menu-title">Categories</div>
						</a>
						<ul>
							<li> <a href="{{route('owner.category.create')}}"><i class="bx bx-right-arrow-alt"></i>Manage Categories</a></li>
						</ul>
					</li>

                    <li>
						<a class="has-arrow" href="javascript:;">
							<div class="parent-icon"><i class="bx bx-spa"></i>
							</div>
							<div class="menu-title">Products</div>
						</a>
						<ul>
							<li> <a href="{{route('owner.product.approval.show')}}"><i class="bx bx-right-arrow-alt"></i>Product Approvals</a></li>
						</ul>
					</li>

                    <li>
						<a class="has-arrow" href="javascript:;">
							<div class="parent-icon"><i class="bx bx-spa"></i>
							</div>
							<div class="menu-title">Orders</div>
						</a>
						<ul>
                            <li> <a href="{{route('owner.order.live')}}"><i class="bx bx-right-arrow-alt"></i>Live Orders</a></li>
							<li> <a href="{{route('owner.order.all')}}"><i class="bx bx-right-arrow-alt"></i>All Orders</a></li>
							<li> <a href="{{route('owner.order.pending')}}"><i class="bx bx-right-arrow-alt"></i>Pending Orders</a></li>
							<li> <a href="{{route('owner.order.confirm')}}"><i class="bx bx-right-arrow-alt"></i>Confirmed Orders</a></li>
							<li> <a href="{{route('owner.order.processing')}}"><i class="bx bx-right-arrow-alt"></i>Processing Orders</a></li>
							<li> <a href="{{route('owner.order.delivered')}}"><i class="bx bx-right-arrow-alt"></i>Delivered Orders</a></li>
						</ul>
					</li>

                    <li>
						<a class="has-arrow" href="javascript:;">
							<div class="parent-icon"><i class="bx bx-spa"></i>
							</div>
							<div class="menu-title">Color Size</div>
						</a>
						<ul>
							<li> <a href="{{route('color.size.group')}}"><i class="bx bx-right-arrow-alt"></i>Color Size</a></li>
						</ul>
					</li>

                    <li>
						<a class="has-arrow" href="javascript:;">
							<div class="parent-icon"><i class="bx bx-spa"></i>
							</div>
							<div class="menu-title">Brand</div>
						</a>
						<ul>
							<li> <a href="{{route('owner.brand.index')}}"><i class="bx bx-right-arrow-alt"></i>Brand</a></li>
						</ul>
					</li>

                    <li>
						<a class="has-arrow" href="javascript:;">
							<div class="parent-icon"><i class="bx bx-spa"></i>
							</div>
							<div class="menu-title">Campaign</div>
						</a>
						<ul>
							<li> <a href="{{route('owner.campaign_types.show')}}"><i class="bx bx-right-arrow-alt"></i>Campaign Types</a></li>
							<li> <a href="{{route('owner.campaigns.show')}}"><i class="bx bx-right-arrow-alt"></i>Campaigns</a></li>
							<li> <a href="{{route('owner.campaigns.add_product')}}"><i class="bx bx-right-arrow-alt"></i>Product Add To Campaigns</a></li>
							{{-- <li> <a href="{{route('owner.campaigns.details')}}"><i class="bx bx-right-arrow-alt"></i>Campaign Details</a></li> --}}
						</ul>
					</li>
					<li>
						<a class="has-arrow" href="javascript:;">
							<div class="parent-icon"><i class="bx bx-spa"></i>
							</div>
							<div class="menu-title">Offers</div>
						</a>
						<ul>
							<li> <a href="{{route('owner.offer.create')}}">
								<i class="bx bx-right-arrow-alt"></i>New</a>
							</li>
							<li> <a href="{{route('owner.offer.index')}}">
								<i class="bx bx-right-arrow-alt"></i>List</a>
							</li>
						</ul>
					</li>					
					<li>
						<a class="has-arrow" href="javascript:;">
							<div class="parent-icon"><i class="bx bx-spa"></i>
							</div>
							<div class="menu-title">Site Settings</div>
						</a>
						<ul>
							<li> <a href="{{route('owner.sitesetting.edit')}}"><i class="bx bx-right-arrow-alt"></i>Site Information</a></li>
							<li> <a href="{{route('owner.logo.edit')}}"><i class="bx bx-right-arrow-alt"></i>Logo</a></li>
							<li> <a href="{{route('owner.slider.index')}}"><i class="bx bx-right-arrow-alt"></i>Sliders</a></li>
						</ul>
					</li>

                    <li>
                        <a class="has-arrow" href="javascript:;">
							<div class="parent-icon"><i class="bx bx-spa"></i>
							</div>
							<div class="menu-title">Vendors</div>
						</a>
						<ul>

							{{-- <li> <a href="{{route('owner.as_vendor.login',['id'=>2])}}"><i class="bx bx-right-arrow-alt"></i>Login as Vendor 2</a></li> --}}

                            <li> <a href="{{route('owner.vendor.create')}}"><i class="bx bx-right-arrow-alt"></i>Create</a></li>
                            <li> <a href="{{route('owner.vendor_list')}}"><i class="bx bx-right-arrow-alt"></i>Vendor List</a></li>

						</ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:;">
							<div class="parent-icon"><i class="bx bx-spa"></i>
							</div>
							<div class="menu-title">Store Setting</div>
						</a>
						<ul>

							{{-- <li> <a href="{{route('owner.as_vendor.login',['id'=>2])}}"><i class="bx bx-right-arrow-alt"></i>Login as Vendor 2</a></li> --}}

                            <li> <a href="{{route('owner.store.list')}}"><i class="bx bx-right-arrow-alt"></i>Store List</a></li>
                            {{-- <li> <a href="{{route('owner.vendor_list')}}"><i class="bx bx-right-arrow-alt"></i>Vendor List</a></li> --}}

						</ul>
                    </li>
				</ul>
				<!--end navigation-->
			</div>
			<!--end sidebar-wrapper-->
			<!--page-content-wrapper-->
			<div class="page-content-wrapper">
				<div class="page-content">

                    @include('layouts.flash_messages')
                    @yield('content')


				</div>
			</div>
			<!--end page-content-wrapper-->
		</div>
		<!--end page-wrapper-->
		<!--start overlay-->
		<div class="overlay toggle-btn-mobile"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<!--footer -->
		<div class="footer">
			<p class="mb-0">Cursor @2020 | Developed By : <a href="#" target="_blank">Cursor</a>
			</p>
		</div>
		<!-- end footer -->
	</div>
	<div id="sina-alert" class="alert font-weight-bold" role="alert" style="position: fixed;width: 200px;top: 60px;right: 1px;z-index: 99; display:none;">
		text
	</div>

    <div id="order_push_notifications" style="width: 500px; position: fixed; bottom: 20px; right: 0; height: auto; overflow: scroll;">

    </div>
	<!-- end wrapper -->
	<!-- JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="{{ asset('css') }}/admin/js/jquery.min.js"></script>
	<script src="{{ asset('css') }}/admin/js/popper.min.js"></script>
	<script src="{{ asset('css') }}/admin/js/bootstrap.min.js"></script>
	<!--plugins-->
    {{-- tags inputs  --}}
	<script src="{{ asset('js') }}/assets/bootstrap-tagsinput.js"></script>
	<script src="{{ asset('js') }}/jquery-confirm.min.js"></script>
	<script src="{{ asset('js') }}/assets/aksFileUpload.js"></script>
	<script src="{{ asset('js') }}/assets/bootstrap-datepicker.min.js"></script>
	<script src="{{ asset('js') }}/assets/bootstrap-datetimepicker.min.js"></script>
	<script src="{{ asset('css') }}/admin/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="{{ asset('css') }}/admin/plugins/metismenu/js/metisMenu.min.js"></script>
	{{-- <script src="{{ asset('css') }}/admin/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script> --}}
	<!--Apex chart-->
	{{-- <script src="{{ asset('css') }}/admin/plugins/apexcharts-bundle/js/apexcharts.min.js"></script> --}}
	{{-- <script src="{{ asset('css') }}/admin/js/widgets.js"></script> --}}
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script src="{{ asset('assets') }}/admin/api.js"></script>
									

	@yield('js')
	<!-- App JS -->
	<script src="{{ asset('css') }}/admin/js/app.js"></script>
    @include('notification');
</body>


<!-- Mirrored from codervent.com/synadmin/demo/widgets.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Oct 2020 18:47:16 GMT -->
</html>
