<?php 
    use Intervention\Image\ImageManagerStatic as Image;
    use Illuminate\Support\Facades\Storage;
    function helperAwsLocation($def=1){

        $ara=[
            "1" => "categories/",
            "2" => "products/",
            "3" => "vendor/",
            "4" => "brands/",
            "5" => "vendor_docs/",
            "6" => "products/images/",
            "7" => "store/",
            "8" => "offers/",
            "9" => "sliders/",
        ];
        return $ara[$def];

         //$url = Storage::disk('s3')->url($destinationFolder);
         //$image->move($destinationPath, $uimgname);
         //Storage::disk('s3')->delete('YOUR_FILENAME_HERE');
    }
    function viewS3Image($loc){
        return Storage::disk('s3')->url($loc);  
    }
    function uploadImageToS3($image,$des,$defWidth=400,$defHeight=400,$isResize=1){
        //$destinationFolder=helperAwsLocation(2)."".$uimgname;
        $extension = $image->getClientOriginalExtension();
        if($isResize == 1)
            $normal = Image::make($image)->resize($defWidth, $defHeight)->encode($extension);
        else
            $normal = Image::make($image)->encode($extension);

        Storage::disk('s3')->put($des, (string)$normal, 'public');
    }
    function removeImageFromS3($loc){
        //$destinationFolder=helperAwsLocation(2)."".$uimgname;
        Storage::disk('s3')->delete($loc);  
    }
?>