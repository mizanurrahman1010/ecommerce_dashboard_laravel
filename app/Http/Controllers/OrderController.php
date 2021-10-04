<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\OrderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
//     public function makeconfirm($id)
//   {
//     //dd($id);
//     $order = Order::find($id);
//     $order->status = 2;
//     $order->confirm_at = date("Y-m-d H:i:s");
//     $order->save();
//     return back()->with('success', 'Order delivery Confirmed!');
//   }
    public function makeprocessing($id, Request $request)
    {
        // return $request->message;
        //dd($id);
        $order = Order::find($id);
        $order->update(['status' => 3]);

        if(OrderLog::create([
            'order_id' => $order->id,
            'status_id' => 3,
            'message' => $request->message,
            'done_by' => get_owner_id()
        ])){
            return true;
        }
        // return back()->with('success', 'Order delivery Confirmed!');
    }
    public function makedelivered($id,Request $request)
    {
        //dd($id);
        $order = Order::find($id);
        $order->update(['status' => 4]);

        if(OrderLog::create([
            'order_id' => $order->id,
            'status_id' => 4,
            'message' => $request->message,
            'done_by' => get_owner_id()
        ])){
            return true;
        }
    }
    public function live_order(){
        return view('owner.order.live');
    }

    public function allorder(Request $request){


        // return $request->all();
        if($request->order_no){
            $od_status = 0;
            $type = 0;
            $orders = Order::where('id', $request->order_no)
                ->with('get_user_info:id,name,email','get_order_details.get_product_name:id,name','get_order_details')
                ->with(['get_order_log' => function($q){
                    $q->latest();
                }])->paginate(10)->appends(request()->query());

            return view('owner.order.pending',compact('orders','od_status','type'));
        }else{
            if($request->value){
                $value = $request->value;
            }
            else{
                $value = null;
            }

            if($request->check_status){
                $check_status = $request->check_status;
                if($check_status == 1){
                    $f_o = 'created_at';
                    $od_status = 1;
                }
                elseif($check_status == 2){
                    $f_o = 'confirm_at';
                    $od_status = 2;
                }
                elseif($check_status == 3){
                    $f_o = 'processing_at';
                    $od_status = 3;
                }
                elseif($check_status == 4){
                    $f_o = 'delivered_at';
                    $od_status = 4;
                }
            }
            else{
                $od_status = 0;
            }

            // return $request->all();
            if($request->type == 'hours'){
                $chk_period = Carbon::now()->subHours($value)->format('Y-m-d H:i:s.u');
                $type = 1;
            }
            elseif($request->type == 'days'){
                $chk_period = Carbon::now()->subDays($value)->format('Y-m-d H:i:s.u');
                $type = 2;
            }
            elseif($request->type == 'months'){
                $chk_period = Carbon::now()->subMonths($value)->format('Y-m-d H:i:s.u');
                $type = 3;
            }else{
                $type = 0;
            }

            $orders = Order::oldest()
                ->with('get_user_info:id,name,email','get_order_details.get_product_name:id,name','get_order_details')
                ->with(['get_order_log' => function($q){
                    $q->latest();
                }]);
                if($request->check_status != null && $request->type != null){
                    $orders = $orders->where($f_o, '>=', $chk_period);
                }
                elseif($request->check_status != null){
                    // return "correct";
                    $orders = $orders->where('status',$od_status)->where($f_o, '>=', Carbon::create(1970,1,1,0,0,0));
                }
                elseif($request->type != null){
                    $orders = $orders->where('created_at', '>=', $chk_period)
                                        ->orWhere('confirm_at', '>=', $chk_period)
                                        ->orWhere('processing_at', '>=', $chk_period)
                                        ->orWhere('delivered_at', '>=', $chk_period);
                }

            $orders = $orders->paginate(10)->appends(request()->query());
            // return $orders;
            return view('owner.order.pending',compact('orders','od_status','type'));
        }


    }
  //order status view
    public function pendingorder()
    {
        $orders = Order::oldest()
            ->where('status',1)
            ->with('get_user_info:id,name,email','get_order_details.get_product_name:id,name','get_order_details')
            ->paginate(10)->appends(request()->query());
        $od_status = 1;
        $type = 0;
        // return $orders;
        return view('owner.order.pending',compact('orders','od_status','type'));
    }
    public function confirmorder()
    {
        $orders = Order::oldest()
            ->where('status',2)
            ->with('get_user_info:id,name,email','get_order_details.get_product_name:id,name','get_order_details')
            ->paginate(10)->appends(request()->query());
        $od_status = 2;
        $type = 0;
        return view('owner.order.pending',compact('orders','od_status','type'));
    }
    public function processingorder()
    {
        $orders = Order::oldest()
            ->where('status',3)
            ->with('get_user_info:id,name,email','get_order_details.get_product_name:id,name','get_order_details')
            ->paginate(10)->appends(request()->query());
        $od_status = 3;
        $type = 0;
        return view('owner.order.pending',compact('orders','od_status','type'));
    }
    public function deliveredorder()
    {
        $orders = Order::oldest()
            ->where('status',4)
            ->with('get_user_info:id,name,email','get_order_details.get_product_name:id,name','get_order_details')
            ->paginate(10)->appends(request()->query());
        $od_status = 4;
        $type = 0;
        return view('owner.order.pending',compact('orders','od_status','type'));
    }

    public function filter_order(Request $request){



        //old system
        // $period = $request->period;
        // if($period == 'today'){
        //     $chk_period = Carbon::today();
        //     $rel = '=';
        // }
        // elseif($period == 'yesterday'){
        //     $chk_period = Carbon::yesterday();
        //     $rel = '=';
        // }
        // elseif($period == 'hour'){
        //     $chk_period = Carbon::now()->addHours(-1)->format('Y-m-d H:i:s.u');
        //     $rel = '>=';
        // }elseif($period == 'week'){
        //     $chk_period = Carbon::now()->addDays(-7)->format('Y-m-d H:i:s.u');
        //     // return $chk_period;
        //     $rel = '>=';
        // }
        // elseif($period == 'month'){
        //     $chk_period = Carbon::now()->addDays(-30)->format('Y-m-d H:i:s.u');
        //     $rel = '>=';
        // }
        // elseif($period == 'year'){
        //     $chk_period = Carbon::now()->addDays(-365)->format('Y-m-d H:i:s.u');
        //     $rel = '>=';
        // }else{
        //     $chk_period = Carbon::create(1970,1,1,0,0,0);
        //     $rel = '>';
        // }

        // $od_status = 4;
        // $orders = Order::oldest()
        //     ->where('status', 4)
        //     ->with('get_user_info:id,name,email','get_order_details.get_product_name:id,name','get_order_details')
        //     ->whereDate('delivered_at',$rel, $chk_period) //for today
        //     // ->whereDate('delivered_at','=', Carbon::yesterday()) //for today
        //     ->get();
        // return view('owner.order.pending',compact('orders','od_status'));
    }

    function get_product_detail(Request $request){
        return Orderdetail::where('order_id', $request->id)
            ->with('get_product_name:id,name')
            ->get();
    }

    function order_detail_approval(Request $request){
        // return $request->all();
        $order = Order::findOrFail($request->cur_order_id);
        DB::transaction(function () use($request, $order) {
            // $order = Order::findOrFail($request->cur_order_id);

            OrderLog::create([
                'order_id' => $order->id,
                'status_id' => 2,
                'message' => $request->message,
                'done_by' => get_owner_id()
            ]);


            // change in order table
            $order->update(['status'=> 2]);
            //details approvals
            $ids = json_decode($request->data);
            Orderdetail::whereIn('id',$ids)->update([
                'approve_status' => 1
            ]);
        });
        return true;

        // if($main_status){
        //     return true;
        // }
    }
}
