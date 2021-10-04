<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{

    public function index(){
        return view('vendor.index');
    }

    public function login()
    {
        if (Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.dashboard');
        } else {
            return view('vendor.login');
        }
    }


    public function logout()
    {
        //dd('logout');
        auth()->guard('vendor')->logout();
        return redirect()->route('vendor.login');
    }


    public function vendorlogincheck(Request $request)
    {
        //   dd($request->all());
        if (auth()->guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('vendor.dashboard');
        } else {
            //dd('pass not match');
            return back();
        }
        // return get_guard();
    }

    public function registration()
    {
        return view('vendor.registration');
    }


//   store create

    function store_create()
    {
        $stores = Store::where('vendor_id', active_user())->get();
        return view('vendor.store.create', compact('stores'));
    }

    function store_save(Request $request)
    {

        $last_info=Store::max('code');
        $last_code=100;
        if(!empty($last_info))
            $last_code=$last_info + 1;

        $data=[
            'name'=> $request->name,
            'code'=> $last_code,
            'address'=> $request->address,
            'contact'=> $request->contact,
            'user_name'=> $request->user_name,
            'password'=> $request->password,
            'Longitude'=> $request->longitude,
            'latitude'=> $request->latitude,
        ];
        $data['vendor_id'] = active_user();
        if ($request->hasfile('store_image')) {

            if ($request->current) {
                $info = Store::findOrFail($request->current);
                $old_imgname = $info->image;
                if (!empty($old_imgname)) {
                    $destinationFolder = helperAwsLocation(7) . "" . $old_imgname;
                    removeImageFromS3($destinationFolder);
                }
            }

            $image = $request->store_image;
            $uimgname = time().uniqid().$image->getClientOriginalExtension();
            $des=helperAwsLocation(7)."".$uimgname;;
            uploadImageToS3($image,$des);
            $data["image"]=$uimgname;
        }

        if ($request->current) {
            if (Store::findOrFail($request->current)->update($data)) {
                return back()->with('success', 'Store Updated Successfully');
            }
        } else {
            if (Store::create($data)) {
                return back()->with('success', 'Store Created Successfully');
            }
        }

        // $data['password'] = bcrypt($request->password);
    }


    function store_edit(Request $request)
    {
        $current = Store::find($request->id);
        $stores = Store::where('vendor_id', active_user())->get();
        return view('vendor.store.create', compact('stores', 'current'));
    }


    function store_delete(Request $request)
    {
        $vendor = active_user();
        $store = Store::find($request->id);
        if ($store->vendor_id == $vendor) {
            if ($store->delete()) {
                return back()->with('danger', 'Store Deleted Successfully');
            }
        } else {
            abort(404);
        }
    }


    function store_status(Request $request)
    {
        $vendor = active_user();
        $store = Store::find($request->id);
        if ($store->vendor_id == $vendor) {
            if ($store->status == 2) {
                if ($store->update(['status' => 1])) {
                    return back()->with('danger', 'Store Status Changed Successfully');
                }
            } else {
                if ($store->update(['status' => 2])) {
                    return back()->with('danger', 'Store Status Changed Successfully');
                }
            }
        } else {
            abort(404);
        }
    }

    //seacrh store from ajax
    function search_store(Request $request)
    {
        $search_item = $request->searchTerm;
        $store_names = Store::select('id', 'name')
            ->where('name', 'LIKE', '%' . $search_item . '%')
            ->orderBy('name', 'asc')
            ->limit(5)
            ->get();
        $data = array();

        foreach ($store_names as $sn) {
            $data[] = array("id" => $sn['id'], "text" => $sn['name']);
        }

        echo json_encode($data);
    }


}
