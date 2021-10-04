<?php

namespace App\Http\Controllers;

use App\Models\DatabaseCart;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    // User Register
    // public function register(Request $request) {
    //     $validator  =   Validator::make($request->all(), [
    //         "name"  =>  "required",
    //         "email"  =>  "required|email",
    //         "phone"  =>  "required",
    //         "password"  =>  "required"
    //     ]);

    //     if($validator->fails()) {
    //         return response()->json(["status" => "failed", "validation_errors" => $validator->errors()]);
    //     }

    //     $inputs = $request->all();
    //     $inputs["password"] = Hash::make($request->password);

    //     $user   =   User::create($inputs);

    //     if(!is_null($user)) {
    //         return response()->json(["status" => "success", "message" => "Success! registration completed", "data" => $user]);
    //     }
    //     else {
    //         return response()->json(["status" => "failed", "message" => "Registration failed!"]);
    //     }
    // }

    // User login
    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            "email" =>  "required|email",
            "password" =>  "required",
        ]);

        if($validator->fails()) {
            return response()->json(["status" => "failed", "validation_errors" => $validator->errors()]);
        }

        $user = User::where("email", $request->email)->first();

        if(is_null($user)) {
            return response()->json(["status" => "failed", "message" => "Failed! email not found"]);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cart = DatabaseCart::where('user_id', $user->id)->get();

            return response()->json(["status" => "success", "login" => true, "token" => $token, "data" => $user, "cart" => $cart]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! invalid password"]);
        }
    }


    //code from anil sidhu
    // function index(Request $request)
    // {
    //     $user= User::where('email', $request->email)->first();
    //     // print_r($data);
    //         if (!$user || !Hash::check($request->password, $user->password)) {
    //             return response([
    //                 'message' => ['These credentials do not match our records.']
    //             ], 404);
    //         }

    //          $token = $user->createToken('my-app-token')->plainTextToken;

    //         $response = [
    //             'user' => $user,
    //             'token' => $token
    //         ];

    //          return response($response, 201);
    // }

    function test_auth(){
        return "Verified";
    }
}
