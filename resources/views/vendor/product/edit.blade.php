@extends('layouts.vendor')

@section('content')

<div class="card">
	<div class="card-header">
        <h5>Create Product</h5>
      </div>
      <div class="card-body">

        <form name="p_form" id="p_form"  class="row">
            <div class="form-group col-4">
                <label>Name:</label>
                <input value="{{$product->name}}" type="text" class="form-control" id="name" name="name"  placeholder="Enter Product Name">
                <small id="name_error" class="form-text text-danger font-weight-bold"></small>
            </div>
            <div class="form-group col-4">
                <label>Stock Quantity:</label>
                <input value="{{$product->stock_quantity}}" type="number" class="form-control" id="stock_quantity" name="stock_quantity"  placeholder="Enter stock quantity">
                <small id="quantity_error" class="form-text text-danger font-weight-bold"></small>
            </div>
            <div class="form-group col-4">
                <label>Unit:</label>
                <select class="form-control" name="unit" id="unit">
                   <option value="">select unit</option>
                   <option {{  1 == $product->unit ? 'selected':''  }} value="1">gram</option>
                   <option {{  2 == $product->unit ? 'selected':''  }} value="2">KG</option>
                   <option {{  3 == $product->unit ? 'selected':''  }} value="3">piece</option>
                </select>
                <small id="unit_error" class="form-text text-danger font-weight-bold"></small>
            </div>
            <div class="form-group col-4">
                <label>Minimum sell Unit:</label>
                <input value="{{$product->min_unit}}" type="number" class="form-control" id="min_unit" name="min_unit"  placeholder="Enter minimum sell unit">
                <small id="min_unit_error" class="form-text text-danger font-weight-bold"></small>
            </div>
            <div class="form-group col-4">
                <label>Store id:</label>
                <input value="{{$product->store_id}}" type="number" class="form-control" id="store_id" name="store_id"  placeholder="Enter minimum sell unit">
                <small id="store_id_error" class="form-text text-danger font-weight-bold"></small>
            </div>
            <div class="form-group col-4">
                <label>Price:</label>
                <input value="{{$product->price}}" type="number" class="form-control" id="price" name="price"  placeholder="Enter minimum sell unit">
                <small id="price_error" class="form-text text-danger font-weight-bold"></small>
            </div>
            <div class="form-group col-4">
                <label>Discount(%):</label>
                <input value="{{$product->discount}}" type="number" class="form-control" id="discount" name="discount"  placeholder="Enter minimum sell unit">
                <small id="discount_error" class="form-text text-danger font-weight-bold"></small>
            </div>
            <div class="col-12 px-0 d-flex flex-wrap">
                <div class="form-group col-4">
                    <label>Category:</label>
                    <select class="form-control" name="category_id" id="categorydropdown">
                        <option value="">Select category</option>
                        @foreach ($categories as $c)
                        <option {{ $c->id == $product->category_id ? 'selected':'' }} value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <small id="category_id_error" class="form-text text-danger font-weight-bold"></small>
                </div>
                <div class="form-group col-4">
                    <label>Sub Category:</label>
                    <select class="form-control" name="sub_category_id" id="subcategorydropdown">
                       <option value="">select</option>
                        @php
                           $sc = App\Models\Category::where('parent_id',$product->category_id)->get();
                        @endphp
                        @foreach ($sc as $sc)
                        <option {{ $sc->id == $product->sub_category_id ? 'selected':'' }} value="{{$sc->id}}">{{$sc->name}}</option>
                        @endforeach

                    </select>
                    <small id="sub_category_id_error" class="form-text text-danger font-weight-bold"></small>
                </div>
                <div class="form-group col-4">
                    <label>Sub Sub Category:</label>
                    <select class="form-control" name="sub_sub_category_id" id="subsubcategorydropdown">
                        <option value="">select</option>
                        @php
                        $ssc = App\Models\Category::where('parent_id',$product->sub_category_id)->get();
                        @endphp
                        @foreach ($ssc as $ssc)
                        <option {{ $ssc->id == $product->sub_sub_category_id ? 'selected':'' }} value="{{$ssc->id}}">{{$ssc->name}}</option>
                        @endforeach
                    </select>
                    <small id="sub_sub_category_id_error" class="form-text text-danger font-weight-bold"></small>
                </div>
            </div>
            <div class="form-group col-12">
                <label>Description:</label>
                <textarea class="form-control" name="description" id="" cols="30" rows="10">{{$product->description}}</textarea>
            </div>

            <div class="form-group col-12">
                <label>Specification:</label>
                <textarea class="form-control" name="specification" id="" cols="30" rows="10">{{$product->specification}}</textarea>
            </div>
            <div class="form-group col-12">
                {{-- <img style="max-width:100px;" src="{{asset('images')}}/productimg/{{$product->image}}" alt=""> --}}
                <label>change image?</label>
                <input type="file" name="image" id="image" class="form-control">
                <small id="image_error" class="form-text text-danger font-weight-bold"></small>
            </div>


            <div class="form-group col-12">
                <input id="p_id" type="hidden" class="btn btn-success mt-3" name="" value="{{$product->id}}">
                <input type="submit" class="btn btn-success mt-3" name="" value="Create Product">
            </div>






        </form>
      </div>


</div>

@endsection



@section('js')

<script>

$('#categorydropdown').on('change', function(e) {
    $('#subsubcategorydropdown').html("<option value=''>select</option>");
    var cat_id = e.target.value;
            $.ajax({
                url:"/vendor/product/loadsubcategory",
                type:"POST",
                data: {
                    id: cat_id
                },
                success:function (response) {
                var data = "<option value=''>select</option>";
                $.each(response, function(key, value) {
                    data = data + "<option value='"+value.id+"'>"+value.name+"</option>"
                })
                $('#subcategorydropdown').html(data);
                }
            })
    });

$('#subcategorydropdown').on('change', function(e) {
    var cat_id = e.target.value;
            $.ajax({
                url:"/vendor/product/loadsubsubcategory",
                type:"POST",
                data: {
                    id: cat_id
                },
                success:function (response) {
                var data = "<option value=''>select</option>";
                $.each(response, function(key, value) {
                    data = data + "<option value='"+value.id+"'>"+value.name+"</option>"
                })
                $('#subsubcategorydropdown').html(data);
                }
            })
    });





    $('#p_form').on('submit', function(event) {
        // alert("he");
        event.preventDefault();
        var myformData = new FormData(this);
        var id = $('#p_id').val();
        // console.log(myformData);


        $.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: myformData,
            enctype: 'multipart/form-data',
            url: "/vendor/product/update/" + id,

            success: function(response) {

                $("html, body").animate({	scrollTop: 0}, 300);

                $("#sina-alert").addClass( "alert-success" ).text("added success").show('slow');
                window.setTimeout(function() {
                    $("#sina-alert").hide("slow").removeClass( "alert-success" ).text("");
                }, 2000);



            },
            error: function(error) {

                $("#sina-alert").addClass( "alert-danger" ).text("wron input").show('slow');
                window.setTimeout(function() {
                    $("#sina-alert").hide("slow").removeClass( "alert-danger" ).text("");
                }, 2000);

            //   $('#name_error').text(error.responseJSON.errors.name);

              $("html, body").animate({	scrollTop: 0}, 300);

            }
        });


    });



</script>
@endsection
