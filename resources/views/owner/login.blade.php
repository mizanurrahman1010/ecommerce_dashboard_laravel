<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from codervent.com/synadmin/demo/authentication-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Oct 2020 18:47:44 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title>Owner</title>
	<!--favicon-->
	<link rel="icon" href="{{ asset('css') }}/admin/images/favicon-32x32.png" type="image/png" />

	<!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('css') }}/admin/css/bootstrap.min.css" />
	
	<link rel="stylesheet" href="{{ asset('css') }}/admin/css/icons.css" />

	<link rel="stylesheet" href="{{ asset('css') }}/admin/css/app.css" />
</head>

<body>
	<!-- wrapper -->
	<div class="wrapper">
		<div class="section-authentication">
			<div class="container-fluid">
				<div class="card mb-0">
					<div class="card-body p-0">
						<div class="row no-gutters">
							<div class="col-12 col-lg-5 col-xl-4 d-flex align-items-stretch">
								<div class="card mb-0 shadow-none bg-transparent w-100 login-card rounded-0">
									<div class="card-body p-md-5">
										<img src="{{ asset('css') }}/admin/images/logo-img.png" width="180" alt="" />
										<h4 class="mt-5"><strong>Owner Login</strong></h4>
										<form method="POST" action="{{route('owner.ownerlogincheck')}}">
											@csrf
											<div class="form-group mt-4">
												<label>Email Address</label>
												<input name="email" type="email" class="form-control" placeholder="example@user.com" />
											</div>
										
											<div class="form-group mt-4">
												<label>Password</label>
												<input name="password" type="password" class="form-control" placeholder="example@user.com" />
											</div>
											<button type="submit" class="btn btn-primary btn-block mt-4"><i class='bx bxs-lock mr-1'></i>Login</button>
										</form>
									
										<div class="text-center mt-4">
											<p class="mb-0">New Vendor? <a href="authentication-login.html">Register Here</a>
											</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-7 col-xl-8 d-flex align-items-stretch">
								<div class="card mb-0 shadow-none bg-transparent w-100 rounded-0">
									<div class="card-body p-md-5">
										<h5 class="card-title">Where does it come from?</h5>
										<p class="card-text">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur.</p>
									</div>
									<img src="{{ asset('css') }}/admin/images/login-images/auth-img-register2.png" class="card-img-top" alt="" />
								</div>
							</div>
						</div>
					</div>
				
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->

</body>


<!-- Mirrored from codervent.com/synadmin/demo/authentication-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Oct 2020 18:47:46 GMT -->
</html>