<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Settings\VatTax;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
// use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Product\ProductSpecification;
use App\Models\Category;
use App\Models\ProductDetailImages;
use Illuminate\Support\Facades\File;
use App\Models\ColorSize;
use App\Models\ProductCasWise;
use App\Models\ProductPrice;
use App\Models\Store;
use App\Models\Settings\SiteFeature;
use App\Models\Setting\WarrentyMonthYear;
use Illuminate\Validation\Rule;
use SebastianBergmann\Environment\Console;
use App\Models\Settings\ProductUnits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Str;
use App\Constraints\SkuGenerator2000;
class ProductController extends Controller
{

    // <<<<<<<<<<<<<<<<<<<<<<<<<<<==================== Admin ====================>>>>>>>>>>>>>>>>>>>>>>

    function color_size_group(){
        $colors = ColorSize::where('parent_id',null)->where('type',1)->with('get_child')->get();
        $sizes = ColorSize::where('parent_id',null)->where('type',2)->with('get_child')->get();

        // return $colors;
        return view('owner.product.color-size-group', compact('colors','sizes'));
    }

    function color_size_group_store(Request $request){


        // return $request->all();

        if($request->group_name){
            $data = [
                'name' => $request->group_name,
                'type' => $request->type,
                'status' => 1,
                'created_by' => 1
            ];
            $group = ColorSize::create($data);
        }
        if($request->values){
            $values = explode(",", $request->values);
            $all_values = array_filter($values, 'trim');

            foreach($all_values as $val){
                $data = [
                    'name' => $val,
                    'type' => $request->type,
                    'parent_id' => $group->id,
                    'status' => 1,
                    'created_by' => 1
                ];

                ColorSize::create($data);
            }
            return back();
        }

    }

    function color_size_group_edit(Request $request){
        if($request->ajax()){
            // $type = $request->type;
            $id = $request->id;

            return ColorSize::where('id',$id)->with('get_child')->first();
        }
    }

    function color_size_group_update(Request $request){

        //edit parent name
        if($request->parent_id){
            ColorSize::where('id', $request->parent_id)->update(['name' => $request->group_name]);
        }

        //edit child name
        if($request->child_id){
            foreach($request->child_id as $key=>$c_id){
                ColorSize::where('id', $c_id)->update(['name' => $request->child_values[$key]]);
            }
        }

        //  add new child

        if($request->add_values){

            $add_values = explode(",", $request->add_values);
            $all_values = array_filter($add_values, 'trim');
            // return $all_values;
            foreach($all_values as $val){
                $data = [
                    'name' => $val,
                    'type' => $request->type,
                    'parent_id' => $request->parent_id,
                    'status' => 1,
                    'created_by' => 1
                ];
                ColorSize::create($data);
            }
        }
        return back();
    }

    function color_size_group_delete(Request $request){
        if($request->ajax()){
            $id = $request->id;
            ColorSize::find($id)->delete();
        }
    }

    //Product Approval

    function product_approval_show(Request $request){
        $products = ProductPrice::where('approve_status','!=',1)
        ->with('get_product_info.get_vendor_name')
        ->with('get_product_info:id,name,vendor_id','get_store_name')
        ->get();
        // return $products;
        return view('owner.product.product_approval', compact('products'));
    }

    function product_approval(Request $request){

        $ids = json_decode($request->data);
        ProductPrice::whereIn('id',$ids)->update([
            'approve_status' => 1
        ]);
        return true;
    }


    // <<<<<<<<<<<<<<<<<<<<<<<<<<<==================== vendors ====================>>>>>>>>>>>>>>>>>>>>>>
  // product create

    public function create(){

        //generateSku();
        $categories=[];$sub_categories=[];$sub_sub_categories=[];
        $units=ProductUnits::where("status",1)->get();
        $colors = ColorSize::where('parent_id',null)->where('type',1)->get();
        $sizes = ColorSize::where('parent_id',null)->where('type',2)->get();
        $departments = Category::where('parent_id', 0)->get();
        $current_product = [];$specifications=[];
        $countries=getCountries();
        $site_offers=getSiteOffers();
        $brands = Brand::get();
        return view('vendor.product.create',compact('sub_sub_categories',
            'sub_categories',
            'departments','categories','countries','specifications',
            'colors','sizes','current_product','site_offers',
            'brands','units'));
    }
    public function store(Request $request){
        // dd($request->all());

        $vendor = active_user();
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        $uimgname = null;
        if($request->current_product > 0)
            {
                $product = Product::find($request->current_product);
                $uimgname = $product->image;
                if(!empty($uimgname) && $request->hasFile('image'))
                {
                    //$destinationFolder=helperAwsLocation(2)."".$uimgname;
                    //Storage::disk('s3')->delete($destinationFolder); 
                    removeImageFromS3(helperAwsLocation(2)."".$uimgname); 
                    
                }
                
            }
        if ($request->hasFile('image')) 
        {
            $image = $request->image;
            $uimgname = time().uniqid().'.'.$image->getClientOriginalExtension();            
            $des=helperAwsLocation(2)."".$uimgname;
            // $extension = $image->getClientOriginalExtension();
            // $normal = Image::make($image)->resize(400, 400)->encode($extension);
            // Storage::disk('s3')->put($destinationFolder, (string)$normal, 'public');
            //$image->move($destinationPath, $uimgname);
            uploadImageToS3($image,$des);
        }
       
       

        if(get_owner_id()){
            $created_type = 1;
            $created_by = get_owner_id();
            $owner_status = 1;
            $vendor_status = 0;
        }else{
            $created_type = 2;
            $created_by = active_user();
            $vendor_status = 1;
            $owner_status = 0;
        }

        $specificationsTitle=$request->title;

        $department_id=$request->department_id;    
        $cate_id=$request->category_id ? $request->category_id : 0;    
        $sub_cate_id=$request->sub_category_id ? $request->sub_category_id : 0;    
        $sub_sub_cate_id=$request->sub_sub_category_id ? $request->sub_sub_category_id : 0;  
        // // $offers=[];
        // // $req_offers=$request->item_offers;
        // // for($i=0;$i < count($req_offers);$i++){
        // //     $offers[]=$req_offers[$i];
        // // }

        // $item_offers_implode=$offers.implode(",");
        // if(count($req_offers) > 0)
        //     $item_offers_implode=$item_offers_implode.",";

        $data=[
            'name'=> $request->name,
            'slug'=> Str::slug(trim($request->name)),
            'department_id'=> $department_id,
            //'stock_maintain_status'=> $request->radio_stock_maintain,
            'category_id'=> $cate_id,
            'sub_category_id'=> $sub_cate_id,
            'sub_sub_category_id'=> $sub_sub_cate_id,
            'unit'=> $request->unit,
            'origin'=> $request->origin,
            //'min_sell_qty'=> $request->min_sell_qty,
            'color_group' => $request->color_group,
            'size_group' => $request->size_group,
            'description'=> $request->description,
            'specification'=> $request->specification,
            'brand_id' => $request->brand,
            //'vendor_id' => $vendor,
            'image'=> $uimgname,
            //'offers_item'=> $item_offers_implode,
            'created_type' => $created_type,
            'created_by' => $created_by,
            'vendor_status' => $vendor_status,
            'owner_status' => $owner_status,
            //"status" => $request->item_status,
        ];
        $product_id=-1;
        if($request->current_product > 0){
            $product->update($data);
            $product_id=$product->id;
        }
        else{
            $data["code"]=generateProductCode();
            $info=Product::create($data);
            $product_id=DB::getPdo()->lastInsertId();
        }

        $status=0;$msg="Something went wrong!!";
        if($product_id > 0){
            ProductSpecification::where("product_id",$product_id)->delete();
            for($i=0;$i< count($specificationsTitle);$i++){
                if(!empty($specificationsTitle[$i]) && !empty($request->value[$i]))
                {
                    $data=[
                        "product_id" => $product_id,
                        'title'=> $specificationsTitle[$i],
                        'value' => $request->value[$i]
                    ];
                    ProductSpecification::create($data);
                }
                $status=1;$msg="Success";
            }

        }
        return response()->json(["status" => $status,"msg" => $msg]);

    }
    //product show
    public function index(Request $request){
        
        $data["imgPUrl"]=Storage::disk('s3')->url(helperAwsLocation(2));  

        $vendor = active_user();
        $categories = Category::where('parent_id', null)->get();
        // $products = Product::with('get_category')->with('get_price_store_wise')->with('get_price_store_wise.get_quantity_store_wise')->paginate(10);
        $products = getProducts();

        // return $products;
        return view('vendor.product.index',compact('products','categories','data'));
    }
    // product edit
    public function edit($id){

        $units=ProductUnits::where("status",1)->get();
        $vendor = active_user();
        $current_product = Product::findOrFail($id);
        abort_if($current_product->vendor_id != $vendor, 404);
        $sub_categories=[];$sub_sub_categories=[];    
        $departments = Category::where('parent_id', 0)->get();
        $categories = Category::where('parent_id', $current_product->department_id)->get();
        if(!empty($current_product->category_id))
            $sub_categories = Category::where('parent_id', $current_product->category_id)->get();

        if(!empty($current_product->sub_category_id))
            $sub_sub_categories = Category::where('parent_id', $current_product->sub_category_id)->get();

        $brands = Brand::get();
        $colors = ColorSize::where('parent_id',null)->where('type',1)->get();
        $sizes = ColorSize::where('parent_id',null)->where('type',2)->get();
        $specifications=ProductSpecification::where("product_id",$id)->get();

        return view('vendor.product.create',compact('categories','specifications',
            'sub_categories','sub_sub_categories','departments',
            'colors','sizes','current_product','brands','units'));
    }
    // product delete

    public function delete(){

        $product = Product::find($id);
        if (File::exists("images/productimg/".$product->image)) {
                File::delete("images/productimg/".$product->image);
            }
        $product->delete();
        return back()->with('success', 'product Deleted!');
    }

  // product update (Not Completed)

    public function update(Request $request,$id){
        //  dd($request->all());
        $validatedData = $request->validate([
            'name' => "required",
        ]);

        $pro = Product::findOrFail($id);
        $old_img = $pro->image;
        // dd($old_img);

        if ($request->hasFile('image')) {
            $path = public_path("/images/productimg/".$old_img);
            //  dd($path);
            if (File::exists($path)) {
                File::delete($path);
            }
            $image = $request->image;
            $uimgname = time().uniqid().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/productimg');
            $image->move($destinationPath, $uimgname);
        }
        else{
            $uimgname = $old_img;
        }

        if($request->discount == null){
            $discount = 0;
            $price = $request->price;
        }
        else{
            $regular_price = $request->price;
            $discount = $request->discount;
            $price = $regular_price - ($regular_price * ($discount / 100));
        }

        $data = Product::findOrFail($id)->update([
            'name'=> $request->name,
            'category_id'=> $request->category_id,
            'sub_category_id'=> $request->sub_category_id,
            'sub_sub_category_id'=> $request->sub_sub_category_id,
            'stock_quantity'=> $request->stock_quantity,
            'store_id'=> $request->store_id,
            'unit'=> $request->unit,
            'min_unit'=> $request->min_unit,
            'description'=> $request->description,
            'specification'=> $request->specification,

            'price'=> $price,
            'regular_price'=> $request->price,

            'discount'=> $discount,
            'image'=> $uimgname,
        ]);

        return response(200);
    }


    //save: product pricing and quantity store wise

    public function product_price()
    {

        $products = getProducts();
        $stores = Store::where('vendor_id', active_user())->get();
        $offer=SiteFeature::where('status',1)->get();
        $vat_tax=VatTax::where('status',1)->where('type',1)->get();
        $warranty=WarrentyMonthYear::where('type',1)->get();
        $warrantyM=WarrentyMonthYear::where('type',2)->get();
        return view('vendor.product.price', compact('products','stores','offer','warranty','warrantyM','vat_tax'));
    }

    function search_product(Request $request){

        $vendor = active_user();
        // return 123;
        // return $request->all();
        //->select('id','name')
        $search_item = $request->searchTerm;
        $product_names = Product::with("get_department")
        // ->where('approve_status',1)
        //->where('vendor_id', $vendor)
        ->where('name','LIKE','%'.$search_item.'%')
        ->orderBy('name','asc')
        ->limit(5)
        ->get();

        $data = array();

        foreach($product_names as $pn){
            $data[] = array("id"=>$pn['id'], "text"=>$pn['name']."-".$pn->get_department->name);
        }
        echo json_encode($data);
    }

    function fill_product_info(Request $request){
        $product = Product::where('id',$request->id)
        ->with('get_category')
        ->with('get_color_group')
        ->with('get_size_group')
        ->first();
        return $product;
    }

    public function product_set_price(Request $request){

        if($request->p_id){
            $product = Product::find($request->p_id);
            $stores = Store::where('vendor_id', active_user())->get();

            $colors = ColorSize::where('parent_id',$product->color_group)->get();
            $sizes = ColorSize::where('parent_id',$product->size_group)->get();
            // return $colors;

            return view("vendor.product.setprice", compact('product','stores','colors','sizes'));
        }
    }

    function product_set_price_store(Request $request){
        // return $request->input();

        if($request->product_id && $request->store_id){

            if(get_owner_id()){
                $created_type = 1;
                $created_by = get_owner_id();
                $approve = 1;
            }
            else{
                $created_type = 2;
                $created_by = active_user();
                $approve = 0;
            }

            $status=1;
            $last_info=ProductPrice::max('code');
            $last_code=1;
            if(!empty($last_info))
                $last_code=$last_info + 1;

            $vendor_id=active_user();
            $store_id=$request->store_id;
            $product_id=$request->product_id;
            $sku=getCodeSku($vendor_id,$store_id,$product_id,$last_code);

            $warranty_y=$request->warranty_year;
            $warranty_m=$request->warranty_month;
            $warranty_total_m=($warranty_y*12)+$warranty_m;

            $strProductTypes="";
            $reqProdductType=$request->product_offer;
            if($reqProdductType==null)
                $reqProdductType=[];
            if(empty($reqProdductType))
                $reqProdductType=[];
            if(count($reqProdductType) > 0){
                $list_ptypes=[];
                for ($i=0;$i < count($reqProdductType);$i++){
                    $list_ptypes[]=$reqProdductType[$i];
                }
                $strProductTypes=implode(",",$list_ptypes);
                $strProductTypes=$strProductTypes.",";

            }

            if($request->price_update != null){

                $product_price_id = ([
                    'code' =>$last_code,
                    'vendor_id' => $vendor_id,
                    'product_id' =>$request->product_id,
                    'store_id' => $request->store_id,
                    'price' => $request->price,
                    'discount' => ($request->discount) ? $request->discount : 0,

                    'vat' => $request->vat,
                    'warranty_months' => $warranty_total_m,
                    'item_offer' => $strProductTypes,
                    'minimum_sell_unit' => ($request->m_unit > 0) ? $request->m_unit : 1,
                    'product_quantity' => $request->quantity_s,
                    'sku' => $sku,
                    'status' => $status,
                    //'quantity' => $request->quantity_without_cs,
                    'approve_status' => $approve,
                    'cur_status' => 1,
                ]);

                ProductPrice::find($request->pp_id)->update($product_price_id);
                $pp_id = $request->pp_id;

                if(isset($request->quantity)){
                    foreach($request->quantity as $key=>$qty){

                        // return $qty;
                        $product_qty = ProductCasWise::where('pp_id', $pp_id)->where('color_id', $request->colors[$key])->where('size_id', $request->sizes[$key])->first();

                        $data = [
                            'color_id' => $request->colors[$key],
                            'size_id' => $request->sizes[$key],
                            'pp_id' => $pp_id,
                            'quantity' => $qty
                        ];

                        if($product_qty){
                            $product_qty->update($data);
                        }
                        else{
                            if($qty>0){
                                ProductCasWise::create($data);
                            }
                        }
                    }
                }
            }
            else{
                $product_price_id = ([
                    'code' =>$last_code,
                    'vendor_id' => $vendor_id,
                    'product_id' =>$request->product_id,
                    'store_id' => $request->store_id,
                    'price' => $request->price,
                    'discount' => ($request->discount) ? $request->discount : 0,

                    'vat' => $request->vat,
                    'warranty_months' => $warranty_total_m,
                    'item_offer' => $strProductTypes,
                    'minimum_sell_unit' => ($request->m_unit > 0) ? $request->m_unit : 1,
                    'product_quantity' => $request->quantity_s,
                    'sku' => $sku,
                    'status' => $status,

                    //'quantity' => $request->quantity_without_cs,
                    'approve_status' => $approve,
                    'cur_status' => 0,
                    'created_by' => $created_by,
                    'created_type' => $created_type
                ]);

                // return "create";
                $pp_id = ProductPrice::create($product_price_id);

                if($request->quantity){
                    foreach($request->quantity as $key=>$qty){
                        if($qty>0){
                            ProductCasWise::create([
                                'pp_id' => $pp_id->id,
                                'color_id' => $request->colors[$key],
                                'size_id' => $request->sizes[$key],
                                'quantity' => $qty
                            ]);
                        }
                    }
                }


            }


        }

        return redirect()->back()->with('message', 'Success');


    }

    function data_store_wise(Request $request){
        return ProductPrice::where('product_id',$request->product_id)
        ->where('store_id', $request->store_id)
        ->first();
    }
    function product_price_list(Request $request){
        $product_prices = Product::
            with('get_price_store_wise','get_price_store_wise.get_store_name:id,name')
            ->paginate(3);
        // return $product_prices;
        return view('vendor.product.price_list', compact('product_prices'));
    }
    // return pricing to ajax->modal
    function get_product_price_store_wise(Request $request){
        if($request->ajax()){
            return ProductPrice::find($request->id);
        }
    }
    // update price
    function update_product_price_store_wise(Request $request){

        return $request->all();

        if(get_owner_id()){
            $approve = 1;
        }
        else{
            $approve = 0;
        }

        $status = ProductPrice::find($request->pp_id)->update([
            'price' => $request->price,
            'discount' => $request->discount,
            'approve_status' => $approve,
            'cur_status' => 1

        ]);
        if($status){
            return back()->with('success','Price Updated Successfully');
        }
    }
    // edit product qty
    function get_product_qty(Request $request){                                     //get price quantity
        $qty_cs_wise = ProductCasWise::where('pp_id',$request->pp_id)->get();
        $product_id = Product::find($request->id)->id;
        $product = Product::find($product_id);
        $color_group = $product->color_group;
        $size_group = $product->size_group;

        $colors = ColorSize::where('parent_id',$color_group)->get();
        $sizes = ColorSize::where('parent_id',$size_group)->get();

        // return $qty_cs_wise;

        $data = '<table class="table"><tr><th>Size</th><th>Color</th><th>Qty</th></tr>';

            foreach($sizes as $size){
                    $data .= '<tr><td>'.$size->name.'</td><td>';
                        foreach ($colors as $color){
                            $data .= '<input type="hidden" name="sizes[]" value="'.$size->id.'">'.
                            '<input type="hidden" name="colors[]" value="'.$color->id.'">'.
                            '<div class="d-flex justify-content-between mt-2">'.
                                '<p class="d-inline-block">'.$color->name.'</p>'.
                                '<input style="width: 70%;" type="text" value="';
                                 foreach($qty_cs_wise as $qty){
                                    if($qty->size_id == $size->id){
                                        if($qty->color_id == $color->id){
                                            $data .= $qty->quantity;
                                        }
                                    }
                                 }

                                 $data .= '" name="quantity[]" class="form-control d-inline-block">'.
                            '</div>';
                        }
                    $data.= '</td></tr>';
                }
        $data .='</table>';


        return $data;

        // foreach($sizes as $size){
        //     foreach($colors as $color){

        //     }
        // }
    }
    //add product qty
    function add_product_qty(Request $request){

        $product = Product::find($request->id);
        $color_group = $product->color_group;
        $size_group = $product->size_group;

        $colors = ColorSize::where('parent_id',$color_group)->get();
        $sizes = ColorSize::where('parent_id',$size_group)->get();

        // return $qty_cs_wise;

        $data = '<table class="table"><tr><th>Size</th><th>Color</th><th></th></tr>';

            foreach($sizes as $size){
                    $data .= '<tr><td>'.$size->name.'</td><td>';
                        foreach ($colors as $color){
                            $data .= '<input type="hidden" name="sizes[]" value="'.$size->id.'">'.
                            '<input type="hidden" name="colors[]" value="'.$color->id.'">'.
                            '<div class="d-flex justify-content-between mt-2">'.
                                '<p class="d-inline-block">'.$color->name.'</p>'.
                                '<input placeholder="Qty" style="width: 50%;" type="text" value="" name="quantity[]" class="form-control d-inline-block">'.
                                '<input type="checkbox" value='.$color->id.' name="checked_qty[]" class="d-inline-block">'.

                            '</div>';
                        }
                $data.= '</td></tr>';
                }
        $data .='</table>';


        return $data;

        // foreach($sizes as $size){
        //     foreach($colors as $color){

        //     }
        // }
    }
    function update_product_qty(Request $request){

        // return $request->input();
        $pp_id = $request->current_pp_id;

        foreach($request->quantity as $key=>$qty){

            // return $qty;
            $product_qty = ProductCasWise::where('pp_id', $pp_id)->where('color_id', $request->colors[$key])->where('size_id', $request->sizes[$key])->first();

            $data = [
                'color_id' => $request->colors[$key],
                'size_id' => $request->sizes[$key],
                'pp_id' => $pp_id,
                'quantity' => $qty
            ];

            if($product_qty){
                $product_qty->update($data);
            }
            else{
                ProductCasWise::create($data);
            }
        }

        return back();
    }
    // <<<<<<<<<<<<<<<<<<<<<<================add details image====================>>>>>>>>>>>>>>>>>>>>>>>>
    public function addmoreimage($id){
        $productimages = ProductDetailImages::where('productid',$id)->get();
        $pImgLoc=Storage::disk('s3')->url(helperAwsLocation(6));  

        // return $productimages;
        return view('vendor.product.addmoreimage',compact('productimages','id','pImgLoc'));
    }
  //details image delete
    public function detailimagedelete($id){
        $detailimage = ProductDetailImages::find($id);
        $detailimagename =  $detailimage->imagename;
        if(!empty($detailimagename)){
            //Storage::disk('s3')->delete(helperAwsLocation(6)."".$detailimagename);
            removeImageFromS3(helperAwsLocation(6)."".$detailimagename);
        }
        // $currentimg = public_path("/images/product_images/".$detailimagename);
        // if (File::exists(public_path("images/product_images/".$detailimagename))) {
        //         File::delete(public_path("images/product_images/".$detailimagename));
        //     }
        //     else{
        //         return "something wrong";
        //     }
        $detailimage->delete();
        return back()->with('success', 'product Deleted!');
    }

  //details image update

    public function detailimageupdate(Request $request){

        $detailimage = ProductDetailImages::findOrFail($request->id);
        $currentimgname = $detailimage->imagename;

        // if (File::exists(public_path("images/product_images/".$currentimgname))) {
        //     File::delete(public_path("images/product_images/".$currentimgname));
        // }
        // else{
        //     return "something wrong";
        // }

        $this->validate($request, [
            'newimage' => 'required',
            'newimage.*' => 'image'
        ]);

        if ($request->hasfile('newimage')) {

            $image = $request->newimage;
            $uimgname = time().rand(1,100).'.'.$image->getClientOriginalExtension();
            
            //$destinationPath = public_path('/images/product_images');
            //$image->move($destinationPath, $uimgname);
            if(!empty($currentimgname)){
                //Storage::disk('s3')->delete(helperAwsLocation(6)."".$currentimgname);
                removeImageFromS3(helperAwsLocation(6)."".$currentimgname);
            }

            // $extension = $image->getClientOriginalExtension();
            // $normal = Image::make($image)->resize(400, 400)->encode($extension);
            $des=helperAwsLocation(6)."".$uimgname;
            // Storage::disk('s3')->put($destinationFolder, (string)$normal, 'public');
            uploadImageToS3($image,$des);

            $detailimage->imagename = $uimgname;
            $detailimage->save();
            return back()->with('succes','Image Updated Successfully');
        }
        else{
            return "no file gotten";
        }
    }

  // add new product detail image
    public function addmoreimagesave(Request $request, $id){

        $this->validate($request, [
            'productimage' => 'required',
            'productimage.*' => 'image'
        ]);

        if($request->hasfile('productimage')){
            foreach($request->file('productimage') as $file){
                $filesave = new ProductDetailImages();
                $imgname = time().rand(1,100).'.'.$file->getClientOriginalExtension();
                
                $extension = $file->getClientOriginalExtension();


                // $normal = Image::make($file)->resize(400, 400)->encode($extension);
                $des=helperAwsLocation(6)."".$imgname;
                // Storage::disk('s3')->put($destinationFolder, (string)$normal, 'public');
                uploadImageToS3($file,$des);

                // Storage::disk('s3')->put($destinationFolder, 
                // fopen($normal, 'r+'), 's3');

                $filesave->imagename = $imgname;
                //$file->move(public_path('images/product_images'), $imgname);
                $filesave->productid = $id;
                $filesave->status = 1;
                $filesave->save();

            }
        }
        return back()->with('success', 'Your images has been successfully added');
    }
  // product filter
    public function filter(Request $request){
        $categories = Category::where('parent_id', null)->get();

        if(!$request->category_id && !$request->category_id && !$request->category_id){
        $products = Product::paginate(10);
        }

        else{
            $products = Product::where('category_id','=',$request->category_id)
                                ->where('sub_category_id','=',$request->sub_category_id)
                                ->where('sub_sub_category_id','=',$request->sub_sub_category_id)->paginate(10);
            $products->setPath(url()->full());
        }
        return view('vendor.product.index',compact('products','categories'));
    }
  //load sub category
    public function getCategoriesApi(Request $request){

        $parent_id = $request->id;
        $level_id=$request->level_id;
        
        $subcategories = Category::
            where(function($q) use ($parent_id){
                if(!empty($parent_id))
                    $q->where('parent_id',$parent_id);
                else
                    $q->whereNull('parent_id');
            })
            ->where(function($q) use ($level_id){
                if(empty($level_id))
                    $q->whereNull("level");
                else if(!empty($level_id))
                    $q->where("level",$level_id);        
            })
            ->get();
        return response()->json($subcategories);
    }
    public function loadsubsubcategory(Request $request){
        $parent_id = $request->id;
        $subsubcategories = Category::where('parent_id',$parent_id)->get();
        return response()->json($subsubcategories);
    }
    function product_name(Request $request){
        $search_item = $request->searchTerm;
        // $vendor = Store::find($request->store);
        // $vendor_id = $vendor->vendor_id;
        if($request->store != 'null'){
            $product_of_store = ProductPrice::select('product_id')->where('store_id', $request->store)->get();
        }

        // return $product_of_store;
        $product_names = Product::select('id','name')
        // ->where('vendor_id', $vendor_id)
        ->whereIn('id', $product_of_store)
        ->where('name','LIKE','%'.$search_item.'%')
        ->orderBy('name','asc')
        ->limit(5)
        ->get();
        $data = array();

        foreach($product_names as $pn){
            $data[] = array("id"=>$pn['id'], "text"=>$pn['name']);
        }
        echo json_encode($data);
    }
    function get_price(Request $request){
        $price = ProductPrice::where('store_id', $request->store)
            ->where('product_id', $request->product)
            ->first();

        if($price){
            return $price->price;
        }else{
            return 'product_not_found';
        }
    }

}
