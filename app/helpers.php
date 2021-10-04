<?php

use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;


function active_user(){
    $user_id = auth()->guard(get_guard())->user()->id ?? null;
    return $user_id;
}

function get_guard(){
    // if (Auth::guard('owner')->check()) {
    //     return "owner";
    // } elseif (Auth::guard('vendor')->check()) {
    //     return "vendor";
    // }
    if (Auth::guard('vendor')->check()) 
    {
        return "vendor";
    }

}

function get_owner_id(){
    $user_id = auth()->guard('owner')->user()->id ?? null;
    return $user_id;
}

