<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\ColorSize;
use App\Models\DatabaseCart;
use App\Models\Order;
use App\Models\Orderdetail;
use Session;
use Pusher\Pusher;


class CartController extends Controller
{


    // <<<<<<<<<<<<<<<<<<<<<<<======================== Funtions for API ==========================>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    function cart_product_add_to_tbl(Request $request){

        //when user logged in successfully, session cart product will be saved in database
        // return $request->all();
        $status = 1;
        $user_id = $request->user_id;
        foreach($request->data as $req_data){

            $product = DatabaseCart::where('user_id', $user_id)->where('product_id', $req_data['id'])->first();

            if(!$product){
                $insert_data = DatabaseCart::create([
                    'user_id' => $user_id,
                    'product_id' => $req_data['id'],
                    // 'quantity' => $req_data['quantity'],
                    'color_id' => $req_data['attributes']['color_id'],
                    'size_id' => $req_data['attributes']['size_id'],
                    'store_id' => $req_data['attributes']['store_id'],
                    'price' => $req_data['price']
                ]);

                if(!$insert_data){
                    $status = 0;
                }
            }
        }

        if($status == 1){
            return response()->json(
                [
                    "status" => 1
                ]
            );
        }
    }


    function product_add_to_cart(Request $request){
        $user_id = $request->user_id;
        $insert_data = DatabaseCart::create([
            'user_id' => $user_id,
            'product_id' => $request->data['id'],
                // 'quantity' => $req_data['quantity'],
            'color_id' => $request->data['attributes']['color_id'],
            'size_id' => $request->data['attributes']['size_id'],
            'store_id' => $request->data['attributes']['store_id'],
            'price' => $request->data['price']
        ]);

        if($insert_data){
            return 1;
        }
    }

    function remove_item_from_db_cart(Request $request){
        $row = DatabaseCart::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->delete();
        return $row;
    }

    //when user logged in, his database cart will show

    // function show_database_cart(Request $request){
    //     return DatabaseCart::where('user_id', $request['user_id'])
    //     ->with('get_product_info:id,name,image','get_color_name:id,name','get_size_name:id,name')
    //     ->get();
    // }


    //when user logged in, his database cart item count
    // function count_database_cart(Request $request){
    //     $count = DatabaseCart::where('user_id', $request['user_id'])->count();
    //     return response()->json(['count' => $count]);
    // }

    //when user logged in, his database cart product color id will return

    function get_color_name(Request $request){
        $color_name = ColorSize::select('name')->where('id', $request->color_id)->first();
        return response()->json(['c_name' => $color_name]);
    }

    function get_size_name(Request $request){
        $size_name = ColorSize::select('name')->where('id', $request->size_id)->first();
        return response()->json(['c_name' => $size_name]);
    }

    function get_product_name(Request $request){
        $product = Product::where('id', $request->id)->first()->name;
        return response()->json(['product'=> $product]);
    }


    function placeorder(Request $request){


        $user_info = $request->user_info;
        $di = $request->delivery_info;
        // return $user_info['id'];

        $status = Order::create([
            'customer_id' => $user_info['id'],
            'total' => $request->total,
            'shipping_cost' => 60,
            'address' => $di['address'],
            'note' => $di['note'],
            'mobile' => $di['mobile'],
            'sub_total' => $request->total + 60,
            'status' => 1
        ]);

        if($status){
            $cart_info = '';
            $customer = Order::where('id',$status->id)->with('get_user_info:id,name')->first();
            $customer_name = $customer->get_user_info->name;
            // return $customer_name;
            foreach($request->cart as $cart){
                $new_status = Orderdetail::create([
                    'order_id' => $status->id,
                    'product_id' => $cart['id'],
                    'price' => $cart['price'],
                    'color_id' => $cart['attributes']['color_id'],
                    'size_id' => $cart['attributes']['size_id'],
                    'store_id' => $cart['attributes']['store_id'],
                    'quantity' => $cart['quantity']
                ]);
                $cart_info .= '<p class="t-heading mb-1"><a href="">'.$cart['name'].'</a>('.$cart['quantity'].'x'.$cart['price'].')</p>';
            }
        }

        if($new_status){
            $resp = DatabaseCart::where('user_id', $user_info['id'])->delete();
        }


            // push notification send to admin
            $options = array(
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true
            );
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );

            $data['customer_name'] = $customer_name;
            $data['address'] = $di['address'];
            $data['mobile'] = $di['mobile'];
            $data['total'] = $request->total;
            $data['id'] = $status->id;
            $data['note'] = $di['note'];
            $data['cart'] = $cart_info;
            $pusher->trigger('order-channel', 'App\\Events\\Order', $data);
            return true;


    }

    // function update_db_cart(Request $request){
    //     $product_id = $request->product_id;
    //     $type = $request->type;
    //     $user = $request->user_id;

    //     if($type == 1){
    //         $dbcart = DatabaseCart::where('user_id', $user)
    //             ->where('product_id', $product_id)
    //             ->first();
    //         $status = $dbcart->update([
    //             'quantity' => $dbcart->quantity + 1
    //         ]);
    //     }

    //     if($type == 0){
    //         $dbcart = DatabaseCart::where('user_id', $user)
    //             ->where('product_id', $product_id)
    //             ->first();
    //         $status = $dbcart->update([
    //             'quantity' => $dbcart->quantity - 1
    //         ]);
    //     }

    // }

    // function get_price_store_wise(Request $request){
    //     return
    // }



    // public function add_to_cart(Request $request)
    // {
    //     // return $request->all();
    //     // dd($request->all());
    //     $product = Product::find($request->id);
    //     $cart = Cart::add([
    //         'rowId'=>$request->id,
    //         'id' => intval($request->id),
    //         'name' => $product->name,
    //         'qty' => $request->qty,
    //         'price' => $product->price,
    //         'weight' => 150,
    //         'options' =>
    //             [
    //                 'image' => $product->image,
    //                 'discount' => 0,

    //             ],
    //     ]);
    //     //Cart::tax(0);
    //     //     return back();

    //     $rowid = $cart->rowId;
    //     $rowqty = $cart->qty;


    //     $inc_dec_btn = '<ul class="list-unstyled list-inline">'.
    //         '<li class="list-inline-item quantity buttons_added cart-inc-desc">'.
    //             '<input type="button"'.
    //             'data-id="'.$rowid.'" data-type="minus" id="decrease" onclick="decreaseValue(this)"'.
    //             'value="-"  class="minus">'.
    //             '<input type="number" step="1" min="1" max="10" id="qty-'.$rowid.'" name="qty" value="'.$rowqty.'" class="qty text" size="4" readonly="">'.
    //             '<span class="incarttxt">In Cart</span>'.
    //             '<input type="hidden" class="form-control text-center" id="rowId-'.$rowid.'" name="rowId" value="'.$rowid.'">'.
    //             '<input type="button"'.
    //             'data-id="'.$rowid.'" data-type="plus" id="increase" onclick="increaseValue(this)"'.
    //              'value="+" class="plus">'.
    //         '</li>'.
    //     '</ul>';

    //     $count = Cart::content()->count();
    //     $data = array(
    //         "count" => $count,
    //         "inc_dec_btn" => $inc_dec_btn
    //     );
    //     echo json_encode($data);

    // }

    // public function isCartExist()
    // {
    //     $total = Cart::subtotal();
    //     $data = array(
    //         "total" => $total,
    //     );
    //     echo json_encode($data);
    // }

    // public function show_cart()
    // {
    //     $cart = Cart::content();
    //     // return $cart;
    //     // exit();
    //     // print_r($cart);
    //     $total = Cart::subtotal();
    //     return view('client.cart.manage_cart', [
    //         'cart' => $cart,
    //         'total' => $total,
    //     ]);
    //     // return $cart;
    // }

    // public function delete_cart($id)
    // {
    //     Cart::remove($id);
    //     $this->getCartInfoAfterChange();
    // }

    // public function update_cart(Request $request)
    // {
    //     Cart::update($request->rowId, $request->qty);
    //     $this->getCartInfoAfterChange();
    // }

    // public function getCartInfoAfterChange()
    // {
    //     ///$info=Cart::get($request->rowId);
    //     $info = array();
    //     $sub_total = Cart::subtotal();
    //     $total = Cart::total();
    //     $cart_list = Cart::content();
    //     $count = Cart::content()->count();
    //     $data = array(
    //         "row" => $info,
    //         "list" => $cart_list,
    //         "sub_total" => $sub_total,
    //         "total" => $total,
    //         "count" => $count,
    //     );
    //     echo json_encode($data);
    // }
}
