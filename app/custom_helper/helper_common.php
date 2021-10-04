<?php

use App\Constraints\SkuGenerator2000;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Settings\Country;
use App\Models\Settings\SiteFeature;
    function getProducts($def_stauts=1){

        $def_vendor_id=0;
        if(empty(get_owner_id())){
            $def_vendor_id=active_user();
        }

        return Product::where('status',1)->where(function($q)use($def_vendor_id){
            if(!empty($def_vendor_id))
                $q->where("created_by",$def_vendor_id)->where("vendor_status",1);
            })
            ->with('get_department:id,name')
            // ->with('get_price_store_wise:id,store_id,price,discount')
            // ->with('get_price_store_wise.get_store_name:id,name')
            ->with('get_colors')
            ->with('get_sizes')
            ->paginate(10);
    }
    function getSiteOffers(){
        $info=SiteFeature::
                where("status",1)
                ->whereIn("type_id",[1,6])
                ->orderBy("sort_id","asc")->get();
        return $info;        
    }
    function validOfferImages($id=0,$pid=0,$status=1){

        $isExist=SiteFeature::find($id);
            $data=["status" => 0,"imagesAR"=> []];
            if(!empty($isExist->id)){
                
                $images=explode(",",$isExist->images);
                for($i=0;$i < count($images);$i++){
                    if(empty($images[$i]))
                        continue;
                    if($images[$i] == $pid){
                        if($status == 1){
                            $data=["id" => $id,"pid" => $pid,"status" => 1,"info" => $isExist];
                            break;
                        }
                        else{
                            $des=helperAwsLocation(8)."".$pid;
                            removeImageFromS3($des);
                            continue;
                        }
                    }
                    $data["imagesAR"][]=$images[$i];
                }

            }
        return $data;
    }
    function generateProductCode()
    {
        $defCode=$maxCode=Product::max("code");
        if(empty($maxCode))
        {
            $defCode=1;
        }
        else{
            $defCode++;
        }
        return str_pad($defCode, 9, '0', STR_PAD_LEFT);
    }
    function generateSku(){
        // Possible variants
        $variants = array(
            'brand' => array(
                array('AP', 'Apple'),
                array('BA', 'Banana'),
                array('PE', 'Pear'),
            ),
            'color' => [],
            // 'color' => array(
            //     array('RE', 'Red'),
            //     array('GR', 'Green'),
            //     array('BL', 'Blue'),
            // ),
        );
        // Rules for combinations I dont want
        $disallow = array(
            array('brand' => 'AP', 'color' => 'GR'), // No green apples
            array('brand' => 'AP', 'color' => 'RE'), // No red apples
            array('brand' => 'PE', 'color' => 'BL'), // No blue pears
        );
       
        $brands_info["brand"]=[];

        $brands=Brand::where("status",1)->get();
        foreach($brands as $val){
            $title=$val->name;
            $ara=[$title[0]."".$title[1],$val->name];
            array_push($brands_info["brand"],$ara);
        }
       
        $skuGenerator = new SkuGenerator2000();
        $skus = $skuGenerator->generate('PHONE1',$brands_info, []);
        // var_dump(array_keys($skus));
        // echo "\n\n";
        // var_dump($skus);
        // exit();
    }
    function getCountries()
    {
        $info=Country::where("status",1)->orderBy("name","asc")->get();
        return $info;
    }
    function getWarrentyMonthYears($def_type=1)
    {
        $info=\App\Models\Setting\WarrentyMonthYear::where("status",1)
            ->where("type",$def_type)
            ->orderBy("name","asc")->get();
        return $info;
    }

    function getCodeSku($vendor_id,$store_id,$product_id,$last_code){
        $v_info=\App\Models\Vendor::findOrFail($vendor_id);
        $v_info = $v_info->code;

        $s_info=\App\Models\Store::findOrFail($store_id);
        $s_info = $s_info->code;

        $p_info=\App\Models\Product::findOrFail($product_id);
        $p_info = $p_info->code;

        $sku=$v_info."-".$s_info."-".$p_info."-".$last_code;
        return $sku;

    }

?>