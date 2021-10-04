<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;

class SubcategoryController extends Controller
{

  public function create()
  {
    $parent = Category::where('parent_id',null)->get();
    return view('owner.subcategory.create',compact('parent'));
  }
  public function get()
  {
    $data = Category::with('parent','child')->where('level',2)->orderBy('created_at','DESC')->get();
    return response()->json($data);
  }
  public function store(Request $request)
  {
    //  dd($request->all());

    $validatedData = $request->validate([
      'name' => 'required|unique:Categories,name|max:255',
      'parent_id' => 'required',
      ]);
    $data=Category::create([
      'name'=> $request->name,
      'parent_id'=> $request->parent_id,
      'level'=> 2,
      'slug'=> Str::slug($request->name, '-'),
    ]);
    return response(200);
  }
  public function edit($id)
  {
    $data = Category::where('id',$id)->first();
    // dd($data);
    return response()->json($data);
  }
  public function update(Request $request,$id)
  {
    // dd($request->all());
    $validatedData = $request->validate([
      'name' => "required|unique:Categories,name,$id",
      'parent_id' => 'required',
      ]);

      $data = Category::findOrFail($id)->update([
        'name'=> $request->name,
        'parent_id'=> $request->parent_id,
        'level'=> 2,
        'slug'=> Str::slug($request->name, '-'),
      ]);
    return response(200);
  }
  public function delete($id)
  {
    $c = Category::findOrFail($id);
    $c->delete();
    return response()->json($c);
  }

}
