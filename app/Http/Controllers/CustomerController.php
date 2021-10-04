<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Sitesetting;
use App\Models\Cart;
use Auth;

class CustomerController extends Controller
{
    // use AuthenticatesUsers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|confirmed|min:6',
            'name' => 'required',
            'email' => 'unique:customers|email|required',
            'phone' => 'required'

        ]);
        $otp = rand(10000,99999);

        $customer = Customer::create([
          'name'=> $request->name,
          'password'=> bcrypt($request->password),
          'phone'=> $request->phone,
          'email'=> $request->email,
          'otp'=> $otp,
        ]);

        $customerid = $customer->id;
        $password=$request->password;


        return view('website.otp',compact('customerid','password','otp'));
    }

    public function matchotp(Request $request)
    {
        $requestotp = $request->otp;
        $customerid = $request->customerid;
        $dbotp = Customer::where('id', $customerid)->first()->otp;

        if( $requestotp ==  $dbotp){
            $customer = Customer::find($customerid);
            $customer->status = 1;

            auth()->guard('customer')->attempt(['email' =>$customer->email, 'password' =>$request->password]);
            $customer->update();

             if(Cart::content()->count() > 0){
                return redirect('/checkout');
            }else{
                return redirect('/');
            }

        }else{
            return view('website.otp',compact('customerid'));
        }

    }
    public function logincheck(Request $request)
    {
        //dd($request->all());
        if(auth()->guard('customer')->attempt(['email' =>$request->email, 'password' =>$request->password])){
            // if(Cart::content()->count() > 0){
            //     return redirect('/checkout');
            // }else{
            //     return redirect()->back();
            // }
            return redirect()->back();

        }else{
            return back();
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MOdels\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
