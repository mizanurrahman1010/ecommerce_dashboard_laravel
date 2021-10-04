<!doctype html>
<html class="no-js" lang="zxx">

<!-- Mirrored from www.thetahmid.com/themes/xemart-v1.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 01 Feb 2021 07:31:02 GMT -->

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Ecommerce</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{asset('images')}}/favicon.ico" type="image/x-icon">
  <link rel="icon" href="{{asset('images')}}/favicon.ico" type="image/x-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{asset('css')}}/assets/bootstrap.min.css">

  <!-- Fontawesome Icon -->
  <link rel="stylesheet" href="{{asset('css')}}/assets/font-awesome.min.css">

  <!-- Animate Css -->
  <link rel="stylesheet" href="{{asset('css')}}/assets/animate.css">

  <!-- image zoom -->
  <link rel="stylesheet" href="{{asset('css')}}/assets/xzoom.css">

  <!-- Owl Slider -->
  <link rel="stylesheet" href="{{asset('css')}}/assets/owl.carousel.min.css">

  <!-- Custom Style -->
  <link rel="stylesheet" href="{{asset('css')}}/assets/normalize.css">
  <link rel="stylesheet" href="{{asset('css')}}/style.css">
  <link rel="stylesheet" href="{{asset('css')}}/assets/responsive.css">


</head>

<body>
@php
    $about = App\Models\Sitesetting::where('id', 1)->first();
@endphp

@yield('page')
@if (!isset($page))
  @php
    $page = "";
  @endphp
@endif


  <!-- Preloader -->
  {{-- <div class="preloader">
    <div class="load-list">
      <div class="load"></div>
      <div class="load load2"></div>
    </div>
  </div> --}}
  <!-- End Preloader -->

  <!-- Logo Area -->
  <section class="logo-area">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="logo">
            <a href="{{route('index')}}"><img src="{{asset('images')}}/aboutimg/{{$about->logo}}" alt=""></a>
          </div>
        </div>
        <div class="col-md-4 padding-fix">
          <form action="{{route('search')}}" method="POST" class="search-bar {{ $page == 'search' ? 'd-none': '' }} ">
            @csrf
            <input type="text" name="searchkeyword" placeholder="I'm looking for...">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>
        </div>
        <div class="col-md-5">
          <div class="carts-area sina-top-fa pl-1 d-flex justify-content-end">
            <div class="call-box d-flex mr-3">
              <div class="call-ico d-none d-lg-block">
                <i class="fa fa-mobile" aria-hidden="true"></i>
              </div>
              <div class="call-content d-none d-lg-block">
                <span>Call Us</span>
                <p>{{$about->phone}}</p>
              </div>
            </div>

            <div class="dropdown">
              <style media="screen"> .user-btns:focus { box-shadow: none !important;} </style>
              <button style="background:none;border:none;" class="btn user-btns btn-secondary mt-2 p-0 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-circle-o m-0" aria-hidden="true"></i>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                @if (Auth::guard('customer')->check())
                <a class="dropdown-item" href="{{route('profile')}}">Profile</a>
                <a class="dropdown-item" href="{{route('editprofile')}}">Edit Profile</a>
                <a class="dropdown-item" href="{{route('orders')}}">My Orders</a>
                <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
                @else

                <a class="dropdown-item" href="{{route('login')}}">Login</a>
                <a class="dropdown-item" href="{{route('registration')}}">Registration</a>

                @endif

              </div>
            </div>




            {{-- <div class="cart-box mx-3 text-center">
              <a href="#" class="">
                <i class="fa fa-heart-o" aria-hidden="true"></i>
                <span>0</span>
              </a>
            </div> --}}
            {{-- <div class="cart-box ml-3 text-center">
              <a href="#" class="cart-btn">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <span>5</span>
              </a>
            </div> --}}
            <div class="cart-box ml-3 text-center">
              <a href="{{route('cart')}}" class="">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <span class="cart_qty">{{Cart::content()->count()}}</span>
              </a>
            </div>
            <div class="cart-box ml-3 text-center">
              <a href="{{route('customer.wishlist')}}" class="">
                <i class="fa fa-heart" aria-hidden="true" style="font-size: 30px;"></i>

                @php
                    $cid = Auth::guard('customer')->id();
                @endphp
                <span class="wish_qty">{{App\Wishlist::where('customer_id',$cid)->count()}}</span>
              </a>
            </div>


          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Logo Area -->

  <!-- Cart Body -->
  <div class="cart-body">
    <div class="close-btn">
      <button class="close-cart"><img src="{{asset('images')}}/close.png" alt="">Close</button>
    </div>
    <div class="crt-bd-box">
      <div class="cart-heading text-center">
        <h5>Shopping Cart</h5>
      </div>
      <div class="cart-content">
        <div class="content-item d-flex justify-content-between">
          <div class="cart-img">
            <a href="#"><img src="{{asset('images')}}/cart1.png" alt=""></a>
          </div>
          <div class="cart-disc">
            <p><a href="#">SMART LED TV</a></p>
            <span>1 x $199.00</span>
          </div>
          <div class="delete-btn">
            <a href="#"><i class="fa fa-trash-o"></i></a>
          </div>
        </div>
        <div class="content-item d-flex justify-content-between">
          <div class="cart-img">
            <a href="#"><img src="{{asset('images')}}/cart2.png" alt=""></a>
          </div>
          <div class="cart-disc">
            <p><a href="#">SMART LED TV</a></p>
            <span>1 x $199.00</span>
          </div>
          <div class="delete-btn">
            <a href="#"><i class="fa fa-trash-o"></i></a>
          </div>
        </div>
      </div>
      <div class="cart-btm">
        <p class="text-right">Sub Total: <span>$398.00</span></p>
        <a href="#">Order Process</a>
      </div>
    </div>
  </div>
  <div class="cart-overlay"></div>
  <!-- End Cart Body -->

  <!-- Mobile Menu -->
  <section class="mobile-menu-area">
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <div class="mobile-menu">

            <nav id="dropdown">
              <a href="{{route('index')}}"><h4 class="font-weight-bold mt-2">Rupantar</h4></a>
              <ul class="list-unstyled">

                @foreach (App\Models\Category::where('parent_id',null)->get() as $parent)
                <li><a  href="{{route('category',['id'=>$parent->id])}}">{{$parent->name}}</a>

                  <ul class="list-unstyled">

                    @foreach (App\Models\Category::where('parent_id',$parent->id)->get() as $sub)

                    <li><a href="{{route('subcategory',['id'=>$sub->id])}}">{{$sub->name}}</a>
                      <ul class="list-unstyled">

                        @foreach (App\Models\Category::where('parent_id',$sub->id)->get() as $subsub)
                        <li><a href="{{route('subsubcategory',['id'=>$subsub->id])}}">{{$subsub->name}}</a></li>
                        @endforeach

                      </ul>
                    </li>
                    @endforeach

                  </ul>

                </li>
                @endforeach



                <li><a href="#">Pages</a>
                  <ul class="list-unstyled">
                    <li><a href="03-about-us.html">About Us</a></li>
                    <li><a href="04-category.html">Category</a></li>
                    <li><a href="05-single-product.html">Single Product</a></li>

                  </ul>
                </li>
                <li><a href="#">Blog</a>
                  <ul class="list-unstyled">
                    <li><a href="16-blog-one.html">Blog Style 1</a></li>
                    <li><a href="17-blog-two.html">Blog Style 2</a></li>

                  </ul>
                </li>
                <li><a href="20-contact.html">Contact</a></li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </section>


@yield('content')


  <!-- Footer Area -->
  <section class="footer-top">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="f-contact d-flex flex-wrap">
            <h5 class="col-12">Contact Info</h5>
            <div class="f-add col-md-4 col-12">
              <i class="fa fa-map-marker"></i>
              <span>Address :</span>
              <p>{{$about->address}}</p>
            </div>
            <div class="f-email col-md-4 col-12">
              <i class="fa fa-envelope"></i>
              <span>Email :</span>
              <p>{{$about->email}}</p>
            </div>
            <div class="f-phn col-md-4 col-12">
              <i class="fa fa-phone"></i>
              <span>Phone :</span>
              <p>{{$about->phone}}</p>
            </div>
            <div class="f-social col-12">
              <ul class="list-unstyled list-inline">
                @if ($about->facebook)
                   <li class="list-inline-item"><a target="_blank" href="https://{{$about->facebook}}">
                     <i class="fa fa-facebook"></i></a></li>
                @endif
                @if ($about->twitter)
                   <li class="list-inline-item"><a target="_blank" href="https://{{$about->twitter}}">
                     <i class="fa fa-twitter"></i>
                   </a></li>
                @endif
                @if ($about->linkedin)
                   <li class="list-inline-item"><a target="_blank" href="https://{{$about->linkedin}}">
                     <i class="fa fa-linkedin"></i>
                   </a></li>
                @endif
                @if ($about->youtube)
                   <li class="list-inline-item"><a target="_blank" href="https://{{$about->youtube}}">
                     <i class="fa fa-youtube"></i>
                   </a></li>
                @endif
                @if ($about->pinterest)
                   <li class="list-inline-item"><a target="_blank" href="https://{{$about->pinterest}}">
                     <i class="fa fa-pinterest"></i>
                   </a></li>
                @endif

              </ul>
            </div>
          </div>
        </div>
        {{-- <div class="col-md-3">
          <div class="f-cat">
            <h5>Categories</h5>
            <ul class="list-unstyled">
              <li><a href="#"><i class="fa fa-angle-right"></i>Clothing</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Electronics</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Smartphones & Tablets</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Computer & Office</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Home Appliances</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Leather & Shoes</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Kids & Babies</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-3">
          <div class="f-link">
            <h5>Quick Links</h5>
            <ul class="list-unstyled">
              <li><a href="#"><i class="fa fa-angle-right"></i>My Account</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Shopping Cart</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>My Wishlist</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Checkout</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Order History</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Log In</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Our Locations</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-3">
          <div class="f-sup">
            <h5>Support</h5>
            <ul class="list-unstyled">
              <li><a href="#"><i class="fa fa-angle-right"></i>Contact Us</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Payment Policy</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Return Policy</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Privacy Policy</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Frequently asked questions</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Terms & Condition</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i>Delivery Info</a></li>
            </ul>
          </div>
        </div> --}}
      </div>
    </div>
  </section>
  <section class="footer-btm mb-5 mb-sm-0">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <p>Copyright &copy; 2020 | Designed With <i class="fa fa-heart"></i> by <a href="#" target="_blank">CursorBD</a></p>
        </div>

      </div>
    </div>
    <div class="back-to-top text-center d-none d-md-block">
      <img src="{{asset('images')}}/backtotop.png" alt="" class="img-fluid">
    </div>
  </section>
  <!-- End Footer Area -->

  <div class="d-block d-md-none">



    <div class="navbar-bottom d-flex">

      <div id="dropup-content" class="dropup-content">

         @if (Auth::guard('customer')->check())
         <a href="{{route('profile')}}">Profile</a>
         <a href="{{route('editprofile')}}">Edit Profile</a>
         <a href="{{route('orders')}}">My Orders</a>
         <a href="{{route('logout')}}">Logout</a>
         @else

         <a href="{{route('login')}}">Login</a>
         <a href="{{route('registration')}}">Registration</a>

         @endif
       </div>


       {{-- <a href="#contact" class="bot-cus-col">
        <div class="d-flex flex-wrap">
          <div class="col-12 text-center ">
            <i class="fa fa-home" aria-hidden="true"></i>

          </div>
          <div class="col-12 text-center px-0">
            <p class="" >Home</p>
          </div>
        </div>
      </a> --}}

      <a href="{{route('cart')}}" id="fcs" class="bot-cus-col">
        <div class="d-flex flex-wrap">
          <div class="col-12 text-center bottom-cart-holder">
          <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            <p class="cart_qty">{{Cart::content()->count()}}</p>

          </div>
          <div class="col-12 text-center px-0">
            <p class="" >Cart</p>
          </div>
        </div>
      </a>


      <a href="{{route('customer.wishlist')}}" id="fcs" class="bot-cus-col">
        <div class="d-flex flex-wrap">
          <div class="col-12 text-center bottom-cart-holder">
          <i class="fa fa-heart" aria-hidden="true"></i>
            <p class="cart_qty">{{App\Wishlist::where('customer_id',$cid)->count()}}</p>

          </div>
          <div class="col-12 text-center px-0">
            <p class="" >Wishlist</p>
          </div>
        </div>
      </a>


      <a href="{{route('index')}}" class="bot-cus-col imga ">
        <div class="b-r-area" >
        <img  src="{{asset('images')}}/logo.png" alt="">
        </div>
      </a>




      <a href="{{route('orders')}}" class="bot-cus-col ">

        <div class="d-flex flex-wrap">
          <div class="col-12 text-center">
            <i class="fa fa-truck" aria-hidden="true"></i>
          </div>
          <div class="col-12 text-center px-0">
            <p class="" >Orders</p>
          </div>
        </div>
      </a>


      <button type="button" class="bot-cus-col active" onblur="dropupclose()">
        <div class="d-flex flex-wrap bottom-profile-button">
          <div class="col-12 text-center">
            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
          </div>
          <div class="col-12 text-center px-0">
            <p class="" >Profile</p>
          </div>
        </div>
      </button>

    </div>
  </div>


  <div  class="bg-primary srch-area">
    <form class="form-group m-1" action="{{route('search')}}" method="POST">
      @csrf
      <input id="mobile-search-input"  class="form-control" type="text" name="searchkeyword" value="" placeholder="search here">
    </form>
  </div>

  <button type="button" id="mbl-srch" status="0" class="btn btn-primary btn-rounded text-white d-block d-md-none"><i class="fa fa-search" aria-hidden="true"></i> Search</button>


  <div id="cart-loading" class="cart-loading">Loading&#8230;</div>

  <div id="sina-alert" class="alert font-weight-bold" role="alert"
		style="position: fixed;width: 200px;top: 70px;right: 1px;z-index: 99; display:none;">
		text
	</div>

  <!-- =========================================
        JavaScript Files
        ========================================== -->

  <!-- jQuery JS -->
  <script src="{{asset('js')}}/assets/vendor/jquery-1.12.4.min.js"></script>

  <!-- Bootstrap -->
  <script src="{{asset('js')}}/assets/popper.min.js"></script>
  <script src="{{asset('js')}}/assets/bootstrap.min.js"></script>

  <!-- Owl Slider -->
  <script src="{{asset('js')}}/assets/owl.carousel.min.js"></script>

  <!-- Wow Animation -->
  <script src="{{asset('js')}}/assets/wow.min.js"></script>

  <!-- Image zoom Animation -->
  <script src="{{asset('js')}}/assets/xzoom.min.js"></script>



  <!-- Image zoom setup Animation -->
  <script src="{{asset('js')}}/assets/hammer.min.js"></script>

  <!-- Image zoom setup Animation -->
  <script src="{{asset('js')}}/assets/setup.js"></script>

  <!-- Price Filter -->
  <script src="{{asset('js')}}/assets/price-filter.js"></script>

  <!-- Mean Menu -->
  <script src="{{asset('js')}}/assets/jquery.meanmenu.min.js"></script>

  <!-- Custom JS -->
  <script src="{{asset('js')}}/plugins.js"></script>
  <script src="{{asset('js')}}/cart.js"></script>

  @yield('js')

  <script src="{{asset('js')}}/custom.js"></script>


</body>

<!-- Mirrored from www.thetahmid.com/themes/xemart-v1.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 01 Feb 2021 07:31:02 GMT -->

</html>
