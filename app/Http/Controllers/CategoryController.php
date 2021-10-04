<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{


    function search_category(Request $request){
        $search_item = $request->searchTerm;
        $category_names = Category::select('id','name')
        ->where('name','LIKE','%'.$search_item.'%')
        ->orderBy('name','asc')
        ->limit(5)
        ->get();
        $data = array();

        foreach($category_names as $cn){
            $data[] = array("id"=>$cn['id'], "text"=>$cn['name']);
        }
        echo json_encode($data);
    }


  public function create()
  {
    $parent = Category::where('parent_id',null)->get();
    $subparent = Category::where('level',2)->get();
    // return $subparent;
    return view('owner.category.create',compact('parent','subparent'));
  }
  public function get(Request $request)
  {

        $level_id=$request->id;
        $data = Category::with('child')
            ->where(function($q) use ($level_id)
            {
                if(!empty($level_id))
                  $q->where("level",$level_id);  
            })
            ->orderBy('sort_id','asc')
            ->get();

    if($level_id > 1)
      $level_id=$level_id - 1;


    $mainCategories=Category::where("level",$level_id)->get(); 
    $res["list"]=$data;
    $res["categories"]=$mainCategories;
    $res["imgLocation"]= Storage::disk('s3')->url(helperAwsLocation());  
    return response()->json($res);
  }
  public function store(Request $request)
  {
     //dd($request->all());
    $validatedData = $request->validate([
        'name' => 'required|unique:Categories,name|max:255',
        //'image' => 'required',
        'status' => 'required',
      ]);

      if ($request->hasFile('image')) 
      {
          $image = $request->image;
          $uimgname = time().uniqid().'.'.$image->getClientOriginalExtension();
          $destinationPath = public_path('/images/categoryimg');

          $des=helperAwsLocation()."".$uimgname;
          // Storage::disk('s3')->put($destinationFolder, 
          // fopen($request->file('image'), 'r+'), 's3');

          uploadImageToS3($request->file('image'),$des);

          //$url = Storage::disk('s3')->url($destinationFolder);
          //$image->move($destinationPath, $uimgname);
          //Storage::disk('s3')->delete('YOUR_FILENAME_HERE');
      }else{
        $uimgname = null;
      }

      $pid=0;
      if(!empty($request->parent_id))
        $pid=$request->parent_id;

        $data=Category::create([
          'name'=> $request->name,
          'status'=> $request->status,
          'slug'=> Str::slug($request->name, '-'),
          'image'=> $uimgname,
          'parent_id'=> $pid,
          'level'=> $request->level_id_params,
          'sort_id'=> $request->sort_id,
          'home_page_show_status'=> $request->home_page_status,

        ]);
        $res["info"]=["status" => 1,"msg" => "Success","level_id" => $request->level_id_params];
      return response($res);
  }
  public function edit($id)
  {
    $parents=[];
    $info = Category::where('id',$id)->first();
    return response()->json($info);
  }
  public function update(Request $request)
  {

    $id=$request->update_id;
    $cat = Category::findOrFail($id);
    $old_img = $cat->image;

    // dd($old_img);
      if(!empty($id)){

        if ($request->hasFile('image')) {


        if(!empty($cat->image))
        {
            $des=helperAwsLocation()."".$cat->image;
            //Storage::disk('s3')->delete($destinationFolder);
            removeImageFromS3($des);
        }

        $image = $request->image;
        $uimgname = time().uniqid().'.'.$image->getClientOriginalExtension();
        $des=helperAwsLocation()."".$uimgname;
        // Storage::disk('s3')->put($destinationFolder, fopen($request->file('image'), 'r+'), 's3');
        uploadImageToS3($image,$des);

          // $path = public_path("/images/categoryimg/".$old_img);
          // if (File::exists($path)) {
          //     File::delete($path);
          //   }
          // $image = $request->image;
          // $uimgname = time().uniqid().'.'.$image->getClientOriginalExtension();
          // $destinationPath = public_path('/images/categoryimg');
          // $image->move($destinationPath, $uimgname);


        }else{
          $uimgname = $old_img;
        }
        $validatedData = $request->validate([
          'name' => "required|unique:Categories,name,$id",
        ]);
        $data = Category::findOrFail($id)->update([
          'name'=> $request->name,
          'slug'=> Str::slug($request->name, '-'),
          'image'=> $uimgname,
          'status'=> $request->edit_status,
          'sort_id'=> $request->sort_id,
          'home_page_show_status'=> $request->home_page_status,
        ]);
      }
      $res["info"]=["status" => 1,"msg" => "Updated","level_id" => $cat->level];
      return response($res);  
  }
  public function delete(Request $req)
  {

    if(!empty($req->id)){
      $c = Category::findOrFail($id);
      $childcount = Category::where('parent_id',$id)->get()->count();
      if($childcount == 0)
      {
        if (File::exists("images/categoryimg/".$c->image)) 
        {
          //File::delete("images/categoryimg/".$c->image);
        }
        $c->delete();
        return response()->json($c);
      }
    }else{
      return response()->json(['error' => 'Error msg'], 404);
    }

  }

}
