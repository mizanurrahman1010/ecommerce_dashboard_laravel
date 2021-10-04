<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Sitesetting;

class SitesettingController extends Controller
{
  public function edit()
  {
        $setting = Sitesetting::findOrFail(1);
        return view('owner.sitesetting.edit',compact('setting'));
  }
  public function logo()
  {
    $setting = Sitesetting::findOrFail(1);

      return view('owner.sitesetting.logo',compact('setting'));
  }
  public function logoupdate(Request $request, $id)
  {

    // dd($request->logo->getClientOriginalName());
    $setting = Sitesetting::findOrFail(1);

    if ($request->hasFile('logo')) {
      $logo = $setting->logo;
      $path = public_path("/images/aboutimg/".$logo);
       // dd($path);
        if (File::exists($path)) {
          File::delete($path);
        }
          $image = $request->logo;
          $uimgname = time().uniqid().'.'.$image->getClientOriginalExtension();
          $destinationPath = public_path('/images/aboutimg');
          $image->move($destinationPath, $uimgname);
      }
      // dd($uimgname);
      Sitesetting::findOrFail($id)->update([
        'logo'=> $uimgname,
      ]);

      return redirect()->back()->with('success', 'logo updated!');
  }


  public function update(Request $request, $id)
  {
    // dd($request->all());
    // dd($id);
    $validatedData = $request->validate([
      'name' => 'required',
      'phone' => 'required',
      'address' => 'required',
      'email' => 'required',
  ]);

      Sitesetting::findOrFail($id)->update([
        'name'=> $request->name,
        'phone'=> $request->phone,
        'email'=> $request->email,
        'shipping_cost'=> $request->shipping_cost,
        'address'=> $request->address,
        'facebook'=> $request->facebook,
        'twitter'=> $request->twitter,
        'linkedin'=> $request->linkedin,
        'pinterest'=> $request->pinterest,
        'youtube'=> $request->youtube,
      ]);

  return redirect()->back()->with('success', 'setting updated!');
  }
}
