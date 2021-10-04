<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Slider;
class SliderController extends Controller
{
  public function index()
  {
      
      $sliders = Slider::all();
      return view('owner.sitesetting.slider',compact('sliders'));
  }
  public function get()
  {
        $imgLoc=viewS3Image(helperAwsLocation(9)); 
        $data = Slider::orderBy('created_at','DESC')->get();
        return response()->json(["list" => $data,"imgLoc" => $imgLoc]);
  }
  public function delete($id)
  {
        // dd($id);
        $c = Slider::findOrFail($id);
        $name = $c->name;
        // $path = public_path("/images/sliderimg/".$name);
        // if (File::exists($path)) {
        //     File::delete($path);
        // }
        $des = helperAwsLocation(9)."".$name;
        removeImageFromS3($des);  

        $c->delete();
        return response()->json($c);
  }
  public function store(Request $request)
  {

    // dd($request->all());

    $validatedData = $request->validate([
      'name' => 'required|mimes:jpg',
      ]);

      if ($request->hasFile('name')) {
            $image = $request->name;
            $uimgname = time().uniqid().'.'.$image->getClientOriginalExtension();
            $des = helperAwsLocation(9)."".$uimgname;
            uploadImageToS3($image,$des,0,0,0);
            //$destinationPath = public_path('/images/sliderimg');
            //$image->move($destinationPath, $uimgname);
        }

      $data=Slider::create([
        'name'=> $uimgname,
      ]);

    return response(200);
  }
}
