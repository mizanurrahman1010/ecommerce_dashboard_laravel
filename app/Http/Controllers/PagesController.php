<?php

namespace App\Http\Controllers;
use App\Models\Slider;
use App\Models\Category;
// use App\Models\Prodget_price_store_wiseuget_price_store_wisect;
use App\Models\Customer;
use App\Models\Sitesetting;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductDetailImages;
use App\Models\Orderdetail;
use App\Models\WishList;
use App\Models\User;
// use View;
use Illuminate\Http\Request;
// use App\Models\Cart;
// use Session;
use Illuminate\Support\Facades\Auth;


class PagesController extends Controller
{


    // functions for developer testing

    function check_session(){
        return session()->all();
    }

    function remove_session(){
        session()->flush();
    }

  // <<<<<<<<<<<<<<<<<<<<<<========= Functions for API' ========>>>>>>>>>>>>>>>>>>>>>>>>

  public function api_load_categories(){
    $category = Category::where('level', null)->get();
    return $category;
  }

  public function api_sliders(){
    return Slider::get();
  }

  public function api_new_products(){
    return ProductPrice::orderBy('price','desc')
        ->with('get_product_info.get_category:id,name')
        ->with('get_product_info:id,name,category_id,image')
        ->get()
        ->keyBy('product_id');
  }

  public function api_top_selling_products(){
    return ProductPrice::orderBy('price','desc')
        ->with('get_product_info.get_category:id,name')
        ->with('get_product_info:id,name,category_id,image')
        ->get()
        ->keyBy('product_id');
  }


  public function api_product_details(Request $request){
      return Product::where('id',$request->product_id)
        ->with('get_category:id,name','get_price_store_wise','get_colors','get_sizes','get_price_store_wise.get_store_name:id,name')
        // ->with('get_price_store_wise.')
        ->first();
  }


  public function similar_product_category_wise(Request $request){
        $product = Product::select('id')->where('category_id', $request->category)->get();
        return ProductPrice::whereIn('product_id',$product)
        ->where('product_id','!=',$request->product_id)
        ->orderBy('price','desc')
        ->with('get_product_info.get_category:id,name')
        ->with('get_product_info:id,name,category_id,image')
        ->get()
        ->keyBy('product_id');
  }



  // <<<<<<<<<<<<<<<<<<<<<<========= Functions for Other' ========>>>>>>>>>>>>>>>>>>>>>>>>
  // website home page

  public function index()
  {
    return view('website.index');
  }

  //invoice making

  public function invoice($id)
  {
    $invoice = Order::where('id',$id)
        ->with('get_order_details.get_product_name:id,name','get_order_details')
        ->first();
    $site_setting = Sitesetting::first();
    $user_info = User::find($invoice->customer_id);
    // return $user_info;

    // return $invoice;
    return view('website.invoice',compact('invoice','site_setting','user_info'));
  }


  // category

  public function category($id)
  {
    $category_name = Category::where('id',$id)->first()->name;
    $category_product = Product::where('category_id',$id)->paginate(36);
    // return $category_product;
    return view('website.category',compact('category_product','category_name'));
  }

  // sub category


  public function subcategory($id)
  {
    $category = Category::findOrFail($id);
    $parent_category = Category::where('id',$category->parent_id)->first();
    // dd($parent_category);
    $category_name = Category::where('id',$id)->first()->name;
    $category_product = Product::where('category_id',$id)->paginate(36);
    return view('website.subcategory',compact('category_product','category_name','parent_category'));
  }


  // sub sub category

  public function subsubcategory($id)
  {
    $category = Category::findOrFail($id);
    $parent_category = Category::where('id',$category->parent_id)->first();
    $grand_parent_category = Category::where('id',$parent_category->parent_id)->first();
    // dd($parent_category);
    $category_name = Category::where('id',$id)->first()->name;
    $category_product = Product::where('category_id',$id)->paginate(36);
    return view('website.subsubcategory',compact('category_product','category_name','parent_category','grand_parent_category'));
  }


  // product search


  public function search(Request $request)
  {
     //dd($request->all());
    $sk = $request->searchkeyword;
    $filterproducts = Product::where('name', 'like', '%'.$sk.'%')->skip(0)->take(50)->get();

    return view('website.search',compact('filterproducts','sk'));
  }


  // product filter


  public function filter(Request $request)
  {
     //dd($request->all());
    $sk = $request->searchkeyword;
    $pricesort = $request->pricesort;
    $filterproducts =
    Product::where('name', 'like', '%'.$sk.'%')->orderBy('price',$pricesort)->skip(0)->take(50)->get();

    return view('website.search',compact('filterproducts','sk','pricesort'));
  }


  //wishlist

  //add

  public function addtowishlist(Request $request){
    if($request->ajax()){
      if($customer = auth()->guard('customer')->user()){
        $pid = $request->product_id;
        $cid = Auth::guard('customer')->id();

        $wishlist = Wishlist::updateOrCreate([
          'product_id' => $pid,
          'customer_id' => $cid
        ]);

        if($wishlist){
          return 1;
        }
        else{
          return "not working";
        }
        // return back()->with('success','Product Added To Wishlist');
      }
      else{
        return redirect('login')->with('warning','You have to Login First');
      }
    }
    //if link from url
    else{
      abort(404);
    }
  }


  //remove from wishlist


  public function removefromwishlist(Request $request){

    if($request->ajax()){
      if($customer = auth()->guard('customer')->user()){
        $cid = Auth::guard('customer')->id();
        $wid = wishlist::where('customer_id',$cid)->where('product_id',$request->w_id)->delete();
        return 1;
      }
      else{
        return redirect('login')->with('warning','You have to Login First');
      }
    }
    //if link from url
    else{
      abort(404);
    }
  }


  // wishlist view


  public function wishlist(){
    $cid = Auth::guard('customer')->id();
    $cart = Cart::content();
    $wishlist = Wishlist::where('customer_id',$cid)->with('products')->get();
    // return $wishlist;

    return view('website.wish',compact('wishlist','cart'));

  }

  // empty cart

  public function cartempty()
  {
    return view('website.cartempty');
  }


  // checkout


  public function checkout()
  {
    if(Cart::content()->count() < 1){
      return redirect()->route('cartempty');
    }else{
      $shipping_cost = Sitesetting::where('id',1)->first()->shipping_cost;
      $cart = Cart::content();
      $total = Cart::subtotal();
      $t = str_replace( ',', '', $total );
      $sub_total = $t;
      $total = $t + $shipping_cost;
      $customer = auth()->guard('customer')->user();
      return view('website.checkout',compact('customer','cart','total','shipping_cost','sub_total'));
    }
  }


  // placeorder


  public function placeorder(Request $request)
  {
          $shipping_cost = Sitesetting::where('id',1)->first()->shipping_cost;
          $customer_id = Auth::guard('customer')->id();
          $order_id = rand(100,999).$customer_id.time();

          $cart = Cart::content();
          $total = Cart::subtotal();

          $t = str_replace( ',', '', $total );
          $sub_total = $t;

          //dd($cart);
          $validatedData = $request->validate([
            'address' => 'required|min:2',
         ]);


        $order = Order::create([
          'customer_id'=> $customer_id,
          'order_id'=> $order_id,
          'total'=> $t + $shipping_cost,
          'address' => $request->address,
          'note' => $request->note,
          'status' => 1,
          'shipping_cost' => $shipping_cost,
          'sub_total' => $sub_total,
          'pending_at' => date("Y-m-d H:i:s"),

        ]);
        $order = [];

        foreach ($cart as $p) {
          $order[] = [
            'product_id'=> $p->id,
            'price'=> $p->price,
            'quantity'=> $p->qty,
            'order_id'=> $order_id
          ];
        }
        Orderdetail::insert($order);
        Cart::destroy();


        return redirect()->route('orders');
  }


  // product details page


  public function product($id)
  {
    $cid = Auth::guard('customer')->id();
    $product= Product::findOrFail($id);
    $p_d_img = ProductDetailImages::where('productid',$id)->get();
    $similar= Product::inRandomOrder()->limit(7)->get();
    $wishlist = WishList::where('customer_id',$cid)->where('product_id',$id)->first();
    // $cart = Cart::content()->join('products','products.id','cart.id');

    // return $cart;

    return view('website.product',compact('product','similar','p_d_img','wishlist'));
  }

//   public function cart()
//   {
//     $cart = Cart::content();

//     if($cart->count()<=0){
//       return view('website.cartempty');
//     }
//     $total = Cart::subtotal();
//     $shipping_cost = Sitesetting::where('id',1)->first()->shipping_cost;
//     return view('website.cart',compact('cart','total','shipping_cost'));
//   }


  // orders

  public function orders()
  {
    $customer_id = Auth::guard('customer')->id();
    $orders = Order::orderBy('created_at','desc')->where('customer_id',$customer_id)->get();
    return view('website.orders.index',compact('orders'));
  }


  // details order


  public function detailorders($order_id)
  {
  //  dd($order_id);
    $order = Order::orderBy('created_at','desc')->where('order_id',$order_id)->first();
    //dd($order);
    $product_list = Orderdetail::where('order_id',$order_id)->get();
    //dd($product_list);

    return view('website.orders.detail',compact('order','product_list'));
  }


  // cancel orders

  public function cancelorders($id)
  {
    $order = Order::find($id);
    $order->status = 0;
    $order->cancel_at = date("Y-m-d H:i:s");
    $order->save();
    return back()->with('success', 'Order canceled!');

  }


  // delivered order

  public function deliveredorders()
  {
    $customer_id = Auth::guard('customer')->id();
    $orders = Order::orderBy('created_at','desc')->where('status',4)->where('customer_id',$customer_id)->get();

    return view('website.orders.delivered',compact('orders'));
  }


  // order


  public function order()
  {

    return view('website.order');
  }


  // user profile


  public function profile()
  {
    $customer_id = Auth::guard('customer')->id();
    $customer = Customer::where('id',$customer_id)->first();
    //dd($customer);
    return view('website.profile',compact('customer'));
  }


  // edit profile


  public function editprofile()
  {
    $customer_id = Auth::guard('customer')->id();
    $customer = Customer::where('id',$customer_id)->first();
    //dd($customer);
    return view('website.editprofile',compact('customer'));
  }


  // update profile


  public function updateprofile(Request $request)
  {
    //dd($request->all());
    $customer_id = Auth::guard('customer')->id();

    Customer::findOrFail($customer_id)->update([
      'name'=> $request->name,
      'email'=> $request->email,
      'phone'=> $request->phone,
      'address'=> $request->address,
    ]);

    return redirect()->route('profile')->with('message', 'Profile Updated');
  }


  // login

  public function login()
  {
    return "login function called";
  }


  // logout


  public function logout()
  {
    auth()->guard('customer')->logout();
      return redirect()->route('index');
  }

  public function registration()
  {
    if(Auth::guard('customer')->check()){
      return redirect()->route('index');
    }else{
      return view('website.registration');
    }
  }


  // get sliders


  public function getsliders()
  {
    $sliders = Slider::select('name')->orderBy('created_at','DESC')->get();
    return response()->json($sliders);
  }

  // getdesktopcategories

  public function getdesktopcategories()
  {
    $desktop_categories = Category::where('parent_id',null)->with('child')->get();
    return response()->json($desktop_categories);
  }

  // load_highlight_product

  public function load_highlight_product()
  {
    $load_highlight_product = Product::where('highlight',1)->limit(12)->get();

    // return $load_highlight_product;
    $h_data = '';
    // $id = '';

    foreach($load_highlight_product as $hp){
        $a = '';
        if($hp->discount == 0){
            $discount_label = '';
            $regular_price = '<li class="list-inline-item"></li>';
        }else{
            $discount_label = '<span class="salelabel">-'.$hp->discount.'%</span>';
            $regular_price = '<li class="list-inline-item">৳ '.$hp->regular_price.'</li>';
        }

        $id = $hp->id;
        $a = Cart::content()->search(function ($cartItem, $rowId)use($id) {
            return $cartItem->id === $id;
        });

        if($a){
            $cartitem = Cart::get($a);
            $cart_btn_option = '<ul class="list-unstyled list-inline">'.
            '<li class="list-inline-item quantity buttons_added cart-inc-desc">'.
                '<input type="button"'.
                'data-id="'.$cartitem->rowId.'" data-type="minus" id="decrease" onclick="decreaseValue(this)"'.
                'value="-"  class="minus">'.
                '<input type="number" step="1" min="1" max="10" id="qty-'.$cartitem->rowId.'" name="qty" value="'.$cartitem->qty.'" class="qty text" size="4" readonly="">'.
                '<span class="incarttxt">In Cart</span>'.
                '<input type="hidden" class="form-control text-center" id="rowId-'.$cartitem->rowId.'" name="rowId" value="'.$cartitem->rowId.'">'.
                '<input type="button"'.
                'data-id="'.$cartitem->rowId.'" data-type="plus" id="increase" onclick="increaseValue(this)"'.
                 'value="+" class="plus">'.
            '</li>'.
        '</ul>';
        }
        else{
            $cart_btn_option = '<input type="hidden" name="qty" id="qty-'.$hp->id.'" value="1" min="1"/><button type="button" data-id="'.$hp->id.'" onclick="addToCart(this)" class="btn btn-primary w-100" name="button"><i class="fa fa-cart-plus mr-2" aria-hidden="true"></i> Add to cart</button>';
        }
        $h_data .=
            '<div class="new-item">'.
            '<div class="new-img  text-center text-md-left">'.
                '<a href="/product/'.$hp->id.'">'.
                    '<img class="main-img img-fluid" src="/images/productimg/'.$hp->image.'" alt="">'.
                '</a>'.
                $discount_label.
            '</div>'.
            '<div class="tab-heading">'.
                '<p class="mb-0 text-center"><a href="/product/'.$hp->id.'">'.$hp->name.'</a></p>'.
                '<p class="mb-0 text-center"><a href="#">'.$hp->min_unit.' KG</a></p>'.
            '</div>'.
            '<div class="img-content d-flex justify-content-center">'.
                '<div>'.
                    '<ul class="list-unstyled list-inline price">'.
                        '<li class="list-inline-item">৳ '.$hp->price.'</li>'.
                        $regular_price.
                    '</ul>'.
                '</div>'.
            '</div>'.
            '<div class="mb-3 add-to-cart-btns d-flex justify-content-center">'.
                $cart_btn_option.
            '</div>'.
        '</div>';
    }

    // return response()->json($load_highlight_product);
    return $h_data;
  }


  // load_parent_categories

  public function load_parent_categories()
  {
    $load_parent_categories = Category::where('parent_id',null)->get();
    return response()->json($load_parent_categories);
  }

  // load products

  public function load(Request $request)
  {
    $take = $request->limit;
    $skip = $request->start;
  //  dd($request->all());
  $data = Product::skip($skip)->take($take)->select('name', 'price','image','discount','unit','min_unit','id')->get();
//   return response()->json($data);
    $h_data = '';
    foreach($data as $hp){
        $a = '';
        if($hp->discount == 0){
            $discount_label = '';
            $regular_price = '<li class="list-inline-item"></li>';
        }else{
            $discount_label = '<span class="salelabel">-'.$hp->discount.'%</span>';
            $regular_price = '<li class="list-inline-item">৳ '.$hp->regular_price.'</li>';
        }

        $id = $hp->id;
        $a = Cart::content()->search(function ($cartItem, $rowId)use($id) {
            return $cartItem->id === $id;
        });

        if($a){
            $cartitem = Cart::get($a);
            $cart_btn_option = '<ul class="list-unstyled list-inline">'.
            '<li class="list-inline-item quantity buttons_added cart-inc-desc">'.
                '<input type="button"'.
                'data-id="'.$cartitem->rowId.'" data-type="minus" id="decrease" onclick="decreaseValue(this)"'.
                'value="-"  class="minus">'.
                '<input type="number" step="1" min="1" max="10" id="qty-'.$cartitem->rowId.'" name="qty" value="'.$cartitem->qty.'" class="qty text" size="4" readonly="">'.
                '<span class="incarttxt">In Cart</span>'.
                '<input type="hidden" class="form-control text-center" id="rowId-'.$cartitem->rowId.'" name="rowId" value="'.$cartitem->rowId.'">'.
                '<input type="button"'.
                'data-id="'.$cartitem->rowId.'" data-type="plus" id="increase" onclick="increaseValue(this)"'.
                'value="+" class="plus">'.
            '</li>'.
        '</ul>';
        }
        else{
            $cart_btn_option = '<input type="hidden" name="qty" id="qty-'.$hp->id.'" value="1" min="1"/><button type="button" data-id="'.$hp->id.'" onclick="addToCart(this)" class="btn btn-primary w-100" name="button"><i class="fa fa-cart-plus mr-2" aria-hidden="true"></i> Add to cart</button>';
        }
        $h_data .=
            '<div class="new-item col-6 col-md-3 col-lg-2 mb-3 px-1 px-md-2">'.
            '<div class="new-img  text-center text-md-left">'.
                '<a href="/product/'.$hp->id.'">'.
                    '<img class="main-img img-fluid" src="/images/productimg/'.$hp->image.'" alt="">'.
                '</a>'.
                $discount_label.
            '</div>'.
            '<div class="tab-heading">'.
                '<p class="mb-0 text-center"><a href="/product/'.$hp->id.'">'.$hp->name.'</a></p>'.
                '<p class="mb-0 text-center"><a href="#">'.$hp->min_unit.' KG</a></p>'.
            '</div>'.
            '<div class="img-content d-flex justify-content-center">'.
                '<div>'.
                    '<ul class="list-unstyled list-inline price">'.
                        '<li class="list-inline-item">৳ '.$hp->price.'</li>'.
                        $regular_price.
                    '</ul>'.
                '</div>'.
            '</div>'.
            '<div class="mb-3 add-to-cart-btns d-flex justify-content-center">'.
                $cart_btn_option.
            '</div>'.
        '</div>';
    }

    return $h_data;
  }
}
