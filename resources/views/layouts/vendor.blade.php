<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from codervent.com/synadmin/demo/widgets.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Oct 2020 18:47:16 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Ecommerce Vendor</title>
	<!--favicon-->
	<link rel="icon" href="{{ asset('css') }}/admin/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="{{ asset('css') }}/admin/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="{{ asset('css') }}/admin/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="{{ asset('css') }}/admin/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ asset('css') }}/admin/css/pace.min.css" rel="stylesheet" />

	<script src="{{ asset('css') }}/admin/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('css') }}/admin/css/bootstrap.min.css" />
	<!-- Icons CSS -->
	<!--search from select box-->
	<link href="{{ asset('css') }}/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="{{ asset('css') }}/admin/css/icons.css" />
    <style>
        .btn-xs{
            padding: 0.25rem 0.5rem;
            font-size: 12px;
        }
    </style>
	@yield('css')
	<!-- App CSS -->
	<link rel="stylesheet" href="{{ asset('css') }}/admin/css/app.css" />
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
										<p class="designattion mb-0 text-dark">Vendor</p>
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
								<div class="dropdown-divider mb-0"></div>
								<a class="dropdown-item" href="{{route('vendor.logout')}}"><i
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

                    @if(get_owner_id() != null)

                        <li>
                            <a href="{{route('owner.go_to.owner')}}">
                                <div class="parent-icon"><i class="bx bx-ghost"></i>
                                </div>
                                <div class="menu-title">Go To Admin</div>
                            </a>
                        </li>

                    @endif


					<li>
						<a href="{{route('vendor.dashboard')}}">
							<div class="parent-icon"><i class="bx bx-ghost"></i>
							</div>
							<div class="menu-title">Dashboard</div>
						</a>
					</li>
					<li>
						<a class="has-arrow" href="javascript:;">
							<div class="parent-icon"><i class="bx bx-spa"></i>
							</div>
							<div class="menu-title">Products</div>
						</a>
						<ul>
							<li> <a href="{{route('vendor.product.create')}}"><i class="bx bx-right-arrow-alt"></i>Create Product</a></li>
							<li> <a href="{{route('vendor.product.index')}}"><i class="bx bx-right-arrow-alt"></i>Manage Products</a></li>
							<li> <a href="{{route('vendor.product.price')}}"><i class="bx bx-right-arrow-alt"></i>Manage Price</a></li>
							<li> <a href="{{route('vendor.product.price_list')}}"><i class="bx bx-right-arrow-alt"></i>Price List</a></li>

						</ul>
					</li>
                    <li>
						<a class="has-arrow" href="javascript:;">
							<div class="parent-icon"><i class="bx bx-spa"></i>
							</div>
							<div class="menu-title">Store</div>
						</a>
						<ul>
							<li> <a href="{{route('vendor.store.create')}}"><i class="bx bx-right-arrow-alt"></i>Create & Manage Store</a></li>

						</ul>
					</li>


				</ul>
				<!--end navigation-->
			</div>
			<!--end sidebar-wrapper-->
			<!--page-content-wrapper-->
			<div class="page-content-wrapper">
				<div class="page-content">


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
			<p class="mb-0">CURSOR @2021 | Developed By : <a href="https://cursorbd.com" target="_blank">CURSOR BD</a>
			</p>
		</div>
		<!-- end footer -->
	</div>
	<!-- end wrapper -->
	<div id="sina-alert" class="alert font-weight-bold" role="alert"
		style="position: fixed;width: 200px;top: 60px;right: 1px;z-index: 99; display:none;">
		text
	</div>
	<!-- JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="{{ asset('css') }}/admin/js/jquery.min.js"></script>
	<script src="{{ asset('css') }}/admin/js/popper.min.js"></script>
	<script src="{{ asset('css') }}/admin/js/bootstrap.min.js"></script>
	<!--plugins-->
	<script src="{{ asset('css') }}/admin/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="{{ asset('css') }}/admin/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="{{ asset('css') }}/admin/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--Apex chart-->
	{{-- <script src="{{ asset('css') }}/admin/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
	<script src="{{ asset('css') }}/admin/js/widgets.js"></script> --}}
	@yield('js')

	{{-- search from select  --}}
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<!-- App JS -->
	<script src="{{ asset('css') }}/admin/js/app.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script src="{{ asset('assets') }}/admin/api.js"></script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/widgets.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Oct 2020 18:47:16 GMT -->
</html>
