@extends('layouts.vendor')
@section('css')
<style>


</style>
@endsection
@section('content')
<link href="{{ asset('css') }}/admin/css/customTab.css" rel="stylesheet" />
<div class="card">
	<div class="card-header">
        <h5> @if($current_product)Edit @else Create @endif Product</h5>
      </div>
      <div class="card-body">
        <form name="p_form" id="p_form"  class="row">
            <input type="hidden" name="current_product" @if($current_product) value="{{$current_product->id}}" @endif>
            <nav class="sina-nav">
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-product-tab" data-toggle="tab" href="#nav-product" 
                     role="tab" aria-controls="nav-category" aria-selected="true">Master Details</a>
                <a class="nav-item nav-link" id="nav-others-tab" data-toggle="tab" href="#nav-others" 
                    role="tab" aria-controls="nav-subcategory" aria-selected="false">Others</a>
                <a class="nav-item nav-link" 
                    id="nav-highligh-tab" 
                    data-toggle="tab" 
                    href="#nav-highligh" 
                    role="tab" aria-controls="nav-highligh" aria-selected="false">HIGHLIGHTS</a>
                </div>
            </nav>
            <div class="tab-content py-3 px-3" id="nav-tabContent">
                <div class="tab-pane fade show active" 
                    id="nav-product" 
                    role="tabpanel" 
                    aria-labelledby="nav-product-tab">
                    <div class='row'>        
                        <div class="form-group col-4">
                            <label>Name:</label>
                            <input type="text" class="form-control" id="name" @if($current_product) value="{{$current_product->name}}" @endif name="name"  placeholder="Enter Product Name">
                            <small id="name_error" class="form-text text-danger font-weight-bold"></small>
                        </div>
                        <div class="form-group col-4">
                            <label>Unit:</label>
                            <select class="form-control" name="unit" id="unit">
                                    @foreach ($units as $c)
                                        <option @if($current_product) @if($current_product->unit == $c->id) selected @endif @endif value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                            </select>
                            <small id="unit_error" class="form-text text-danger font-weight-bold"></small>
                        </div>
                        
                        <!-- d-flex flex-wrap -->
                        <div class="col-12 px-0 d-flex flex-wrap">
                        <div class="form-group col-4">
                            <label>Minimum sell Unit:</label>
                            <input type="number" class="form-control" 
                                id="min_unit" 
                                    @if($current_product) 
                                        value="{{$current_product->min_sell_qty}}"
                                    @else if(empty($current_product))
                                        value="1"     
                                    @endif
                                    type="number" min="1"
                                    name="min_sell_qty"  placeholder="Enter minimum sell unit">
                                <small id="min_unit_error" class="form-text text-danger font-weight-bold"></small>
                            </div>
                            <div class="form-group col-4">
                                <label>Department:</label>
                                <select onchange="getCategories(this,'category_dropdown',2)" class="form-control" name="department_id" id="departments_dropdown">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $c)
                                     <option @if($current_product) @if($current_product->department_id == $c->id) selected @endif @endif value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <small id="department_id_error" class="form-text text-danger font-weight-bold"></small>
                            </div>
                            <div class="form-group col-4">
                                <label>Category:</label>
                                <select class="form-control" onchange="getCategories(this,'subcategorydropdown',3)" name="category_id" id="category_dropdown">
                                    <option value="">Select</option>
                                    @foreach ($categories as $c)
                                        <option @if($current_product) @if($current_product->category_id == $c->id) selected @endif @endif value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <small id="category_id_error" class="form-text text-danger font-weight-bold"></small>
                            </div>
                            <div class="form-group col-4">
                                <label>Sub Category:</label>
                                <select class="form-control" onchange="getCategories(this,'subsubcategorydropdown',4)"
                                    name="sub_category_id" id="subcategorydropdown">
                                    <option value="">Select</option>
                                    @foreach ($sub_categories as $c)
                                        <option @if($current_product) @if($current_product->sub_category_id == $c->id) selected @endif @endif value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <small id="sub_category_id_error" class="form-text text-danger font-weight-bold"></small>
                            </div>
                            <div class="form-group col-4">
                                <label>Sub Sub Category:</label>
                                <select class="form-control" name="sub_sub_category_id" id="subsubcategorydropdown">
                                    <option value="">Select</option>
                                    @foreach ($sub_sub_categories as $c)
                                        <option @if($current_product) @if($current_product->sub_sub_category_id == $c->id) selected @endif @endif value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <small id="sub_sub_category_id_error" class="form-text text-danger font-weight-bold"></small>
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label>Brand</label>
                            <select name="brand" id="color_group" class="form-control">
                                @foreach ($brands as $brand)
                                    <option @if($current_product) @if($current_product->brand_id == $brand->id) selected @endif @endif value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label>Color Group</label>
                                <select name="color_group" id="color_group" class="form-control">
                                @foreach ($colors as $color)
                                    <option @if($current_product) @if($current_product->color_group == $color->id) selected @endif @endif value="{{$color->id}}">{{$color->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label>Size Group:</label>
                            <select name="size_group" id="size_group" class="form-control">
                                @foreach ($sizes as $size)
                                    <option @if($current_product) @if($current_product->size_group == $size->id) selected @endif @endif value="{{$size->id}}">{{$size->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(!$current_product)@endif
                        <div class="form-group col-4">
                            <label>Product Main Image:</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <small id="image_error" class="form-text text-danger font-weight-bold"></small>
                        </div>
                        <?php 
                            $def_sotck_checked_yes="checked";
                            $def_sotck_checked_no="";
                            if(!empty($current_product)){
                                if($current_product->stock_maintain_status == 2)
                                    {
                                        $def_sotck_checked_yes="";
                                        $def_sotck_checked_no="checked";
                                    }
                            }

                        ?>
                        <div class="form-group col-4">
                            <label>Status</label>
                            <select class="form-control" name="item_status">
                                <option <?php if(!empty($current_product->status) && $current_product->status == 1): ?>selected<?php endif; ?> value="1">
                                    Active
                                </option>
                                <option <?php if(!empty($current_product->status) && $current_product->status == 2): ?>selected<?php endif; ?> value="2">
                                    Inactive
                                </option>
                            </select>
                        </div>
                        
                        <div class="form-group col-4">
                            <label>Origin</label>
                            <select class="form-control jqSelect2" name="origin">
                                @foreach($countries as $val)
                                    <option value="{{$val->id}}">
                                        {{$val->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- @if(get_owner_id())
                            <div class="form-group col-12">
                                <label>Offers</label><input class="global-checkbox" type="checkbox" /> All
                                <div class="col-8">
                                    @foreach($site_offers as $val)
                                        <input name="item_offers[]" value="{{$val->id}}" class="g-input-checkbox" type="checkbox" /> {{$val->name}}
                                    @endforeach 
                                </div>   
                            </div>
                        @endif -->
                    </div>
                </div>
                <div class="tab-pane fade show" 
                    id="nav-others" 
                    role="tabpanel" 
                    aria-labelledby="nav-others-tab">
                                    
                        <div class='row'>
                            <div class="form-group col-12" style="max-height:200px;overflow:auto;">
                                <label>Specification:</label>
                                <div class="row">
                                    <?php
                                        $i=0;
                                        foreach($specifications as $val){
                                            
                                            ?>
                                            <div class="col-sm-4">
                                                <label>Title</label>
                                                <input name="title[<?=$i; ?>]" value="{{$val->title}}" class="form-control" />
                                            </div>
                                            <div class="col-sm-4">
                                                    <label>Value</label>
                                                    <input value="{{$val->value}}" name="value[<?=$i; ?>]" class="form-control" />
                                            </div>
                                            <div class="col-sm-4" style="margin-top:30px;">
                                                <button class="btn btn-primary">
                                                    <i class="lni lni-plus"></i>
                                                </button>
                                            </div>
                                            <?php
                                            $i++;
                                        }
                                    ?>
                                    @for(;$i < 20-count($specifications);$i++)
                                        <div class="col-sm-4">
                                                <label>Title</label>
                                                <input name="title[<?=$i; ?>]" class="form-control" />
                                        </div>
                                        <div class="col-sm-4">
                                                <label>Value</label>
                                                <input name="value[<?=$i; ?>]" class="form-control" />
                                        </div>
                                        <div class="col-sm-4" style="margin-top:30px;">
                                            <button class="btn btn-primary">
                                                <i class="lni lni-plus"></i>
                                            </button>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Description:</label>
                                <textarea class="form-control summernote" name="description" id="" cols="30" rows="5"> @if($current_product){{$current_product->description}} @endif</textarea>
                            </div>
                        </div>
                </div>
                <div 
                    class="tab-pane fade show" 
                    id="nav-highligh" 
                    role="tabpanel" 
                    aria-labelledby="nav-highlight-tab">
                        <div class="form-group col-12">
                            <label>HIGHLIGHTS:</label>
                            <textarea 
                                class="form-control summernote" 
                                name="product_highlights" 
                                id="" cols="30" 
                                rows="3"> @if($current_product){{$current_product->description}} @endif</textarea>
                        </div>
                </div>      
            </div>
            <div class="form-group col-12">
                <input type="submit" class="btn btn-success mt-3" name="" value="@if($current_product) Update @else Create @endif Product">
            </div>
        </form>
      </div>


</div>

@endsection



@section('js')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $('.summernote').summernote({
        height: 400
    });
    
</script>
<script>

    // function color_size_qty(){
    //     var $color_group = $('#select_colors').val();
    //     var $size_group = $('#select_sizes').val();

    //     if($color_group == 0 && $size_group == 0){
    //         $('#open_qty_modal').hide();
    //     }else{
    //         $('#open_qty_modal').show();
    //     }
    // }
    // color_size_qty();


    // $(document).ready(function(){
    //     $('#select_colors, #select_sizes').change(function(){
    //         color_size_qty();
    //     });
    // });

    function getCategories(v,appentTo,level_id){
        var id=$(v).val();
        $.ajax({
                url:"/vendor/product/loadCategories",
                type:"POST",
                data: {
                    id: id,
                    level_id:level_id,
                },
                success:function (response) {

                    var data = "<option value=''>select</option>";
                    $.each(response, function(key, value) {
                        data = data + "<option value='"+value.id+"'>"+value.name+"</option>"
                    })
                    $('#'+appentTo).html(data);
                }
            })
    }


        // $('#categorydropdown').on('change', function(e) {
        //     $('#subsubcategorydropdown').html("<option value=''>select</option>");
        //     var cat_id = e.target.value;
            
        // });

        // $('#subcategorydropdown').on('change', function(e) {
        //     var cat_id = e.target.value;
        //     $.ajax({
        //         url:"/vendor/product/loadsubsubcategory",
        //         type:"POST",
        //         data: {
        //             id: cat_id
        //         },
        //         success:function (response) {
        //         var data = "<option value=''>select</option>";
        //         $.each(response, function(key, value) {
        //             data = data + "<option value='"+value.id+"'>"+value.name+"</option>"
        //         })
        //         $('#subsubcategorydropdown').html(data);
        //         }
        //     })
        // });



    $('#p_form').on('submit', function(event) {
        // alert("he");
        event.preventDefault();
        var myformData = new FormData(this);
        var alertData={showLoading:'true',title:"Loading...",tpb: true,position:'center',aoc:true};
        sweetAlert(alertData);

        $.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: myformData,
            enctype: 'multipart/form-data',
            url: "/vendor/product/store",

            success: function(response) {

                $("#sina-alert").addClass( "alert-success" ).text(response.msg).show('slow');
                $('#p_form').trigger("reset");
                $("html, body").animate({	scrollTop: 0}, 300);
                    
                if(response.status == 1){
                    window.setTimeout(function() {
                        window.location.reload();
                    }, 2000); 
                }
                else{
                    $("#sina-alert").hide("slow").removeClass( "alert-success" ).text("");
                }

                var alertData={title:'Success',timer:1000,toast: true};
                sweetAlert(alertData);

            },
            error: function(error) {

                // $("#sina-alert").addClass( "alert-danger" ).text("wron input").show('slow');
                // window.setTimeout(function() {
                //     $("#sina-alert").hide("slow").removeClass( "alert-danger" ).text("");
                // }, 2000);
                $('#name_error').text(error.responseJSON.errors.name);
                // $("html, body").animate({	scrollTop: 0}, 300);

                var alertData={title:error.responseJSON.errors.name,timer:1000,toast: true};
                sweetAlert(alertData);

            }
        });


    });



</script>
@endsection
