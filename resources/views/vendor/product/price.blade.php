@extends('layouts.vendor')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .filtered_product{
        position: absolute;
        display: none;
        /* background-color: #fff; */
        background-color: #333;
        /* color: #fff; */
        padding: 10px 0;
        width: 100%;
        z-index: 9999;
    }
    .filtered_product a{
        color: #fff;
        padding: 5px;
    }
    .product_entry{
        display: none;
    }
</style>

@endsection
@section('content')

<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h5>Products Price</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form action="">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Search Product By Name</label>
                                <select class="js-live-data-search form-control" name="" id="search_product">
                                    <option value="">Select Product</option>
                                    {{-- @foreach ($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row product_entry">
            <div class="col-12">
                <div class="row">
                    <div class="form-group col-3">
                        <label>Name:</label>
                        <input type="text" class="form-control" id="name" readonly name="name"  placeholder="Enter Product Name">
                    </div>

                    <div class="form-group col-3">
                        <label>Unit:</label>
                        <input type="text" class="form-control" id="unit" readonly>
                    </div>

                    <div class="form-group col-3">
                        <label>Minimum sell Unit:</label>
                        <input type="number" class="form-control" id="min_unit" readonly name="min_sell_qty"  placeholder="Enter minimum sell unit">
                    </div>

                    <div class="form-group col-3">
                        <label>Category:</label>
                        <input type="text" class="form-control" id="category" readonly>
                    </div>

                    <div class="form-group col-3">
                        <label>Sub Category:</label>
                        <input type="text" class="form-control" id="sub-category" readonly>
                    </div>

                    <div class="form-group col-3">
                        <label>Sub Sub Category:</label>
                        <input type="text" class="form-control" id="sub_sub_category" readonly>
                    </div>

                    <div class="form-group col-3">
                        <label>Color Group:</label>
                        <input type="text" class="form-control" id="color_group" readonly>
                    </div>

                    <div class="form-group col-3">
                        <label>Size Group:</label>
                        <input type="text" class="form-control" id="size_group" readonly>
                    </div>

                    <div class="form-group col-6">
                        <label>Description:</label>
                        <textarea class="form-control" name="description" id="description" readonly cols="30" rows="4"></textarea>
                    </div>

                    <div class="form-group col-6">
                        <label>Specification:</label>
                        <textarea class="form-control" name="specification" id="specification" readonly cols="30" rows="4"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">


                    <div class="form-group col-2">
                        <label>Select Store:</label>
                        <select name="store_id" class="form-control get_store_id">
                            <option value="0" selected>Select Store</option>
                            @forelse ($stores as $store)
                                <option value="{{$store->id}}">{{$store->name}}</option>
                            @empty
                                <option value="0">No Store Found</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="col-9" id="create_price">

                        <form action="{{route('product.set_price.store')}}" method="post">
                            @csrf
{{--                            @if(session()->has('message'))--}}
{{--                                <div class="alert alert-success">--}}
{{--                                    {{ session()->get('message') }}--}}
{{--                                </div>--}}
{{--                            @endif--}}
                            <input type="hidden" name="product_id" class="product_id" value="">
                            <input type="hidden" name="store_id" class="store_id" value="">
                            <input type="hidden" name="price_update" class="price_update">
                            <input type="hidden" name="pp_id" class="pp_id">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <input type="hidden" name="update_price">
                                        <div class="form-group col">
                                            <label>Product Price:</label>
                                            <input type="number" class="form-control product_price" name="price"  placeholder="Enter Product Price" required="1">
                                        </div>
                                        <div class="form-group col">
                                            <label>Price status:</label>
                                            <select class="browser-default custom-select price_status" id="price_status" name="price_status">
                                                    <option selected class="" value="1" > Show</option>
                                                    <option class="" value="2" > Hide</option>
                                            </select>
                                        </div>
                                        <div class="form-group col">
                                            <label>Discount (%):</label>
                                            <input type="number" class="form-control product_discount" name="discount" placeholder="Enter Discount Percentage (%)">
                                        </div>

                                        <div class="form-group col">
                                            <label>Vat(%):</label>
                                            <select class="browser-default custom-select product_vat_tax" id="vat" name="vat">
                                                @foreach($vat_tax as $val)
                                                    <option class="vt-{{$val->value}}" value={{$val->value}} > {{$val->name}} </option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="form-group col">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label>Warranty(Year-</label>
                                                    <select class="browser-default custom-select" id="warranty_year" name="warranty_year">
                                                        <option class="wy-0" value="0"></option>
                                                            @foreach($warranty as $val)
                                                                <option class="wy-{{$val->name}}" value={{$val->name}}  >{{$val->name}}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <label>Month):</label>
                                                    <select class="browser-default custom-select" id="warranty_month" name="warranty_month">
                                                        <option class="wm-0" value="0"></option>
                                                        @foreach($warrantyM as $val)
                                                            <option class="wm-{{$val->name}}" value={{$val->name}}>{{$val->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-group col-2">
                                            <label>Minimum sell unit:</label>
                                            <input type="number" class="form-control minimum_sell_unit" name="m_unit"  placeholder="minimum sell unit" >
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="form-group col">
                                            <label>Item Offer:</label><br>

                                            @foreach($offer as $val)
                                                <input id="offer" type="checkbox" name="product_offer[]" class="offer-{{$val->id}}" value="{{$val->id}}"  />   {{$val->name}}<br>
                                            @endforeach
                                        </div>

                                        <div class="form-group col">
                                            <label>Quantity(If Maintain Stock):</label>
                                            <input type="number" class="form-control product_quantity" name="quantity_s" value="0">
                                        </div>
                                        <div class="form-group col">
                                            <label>Stock available status:</label>
                                            <select class="browser-default custom-select stock_available_status" id="stock_available_status" name="stock_available_status">
                                                <option selected class="" value="1" > Show</option>
                                                <option class="" value="2" > Hide</option>
                                            </select>
                                        </div>
                                        <div class="form-group col">
                                            <label>Product Quantity Color&Size:</label><br>
                                            <button type="button" class="btn btn-primary btn-block" data-type="" data-id="" id="set_quantity">Set Quantity</button>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="addQtyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Update Qty</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body add_qty_body">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col">
                                            <label for="">&nbsp;  </label><br>
                                            <input type="submit" class="btn btn-success" name="" value="Save Product">
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // $(document).ready(function() {
    //     $('.js-live-data-search').select2();
    // });
</script>

<script>
    $(document).ready(function(){
        
        $(document).on('change','#search_product', function(){

            var id = $(this).val();
            $.ajax({
                url: '/vendor/product/fill_product_info',
                type: 'get',
                data: {id:id},
                success: function(response){
                    // $('.product_entry').show();
                    // console.log(response);
                    $('#name').val(response.name);
                    $('#unit').val(response.unit);
                    $('#min_unit').val(response.min_sell_qty);
                    // $('#category').val(response.get_category.name);
                    // $('#sub_category').val(response.sub_category_id);
                    // $('#sub_sub_category').val(response.sub_sub_category_id);
                    $('#color_group').val(response.get_color_group.name);
                    $('#size_group').val(response.get_size_group.name);
                    $('#description').val(response.description);
                    $('#specification').val(response.specification);

                    $('.product_id').val(response.id);
                    $('.product_entry').slideDown();
                    $('#set_quantity').attr('data-id',response.id);
                    store_wise_update();
                }
            });
        });
        $('.get_store_id').change(function(){
            store_wise_update();
        });
        function store_wise_update(){
            var store_id = $('.get_store_id').val();
            var product_id = $('.product_id').val();
            $('.store_id').val(store_id);

            if(store_id == 0){
                $('#create_price').hide();
            }
            else{
                $.ajax({
                    url: '/vendor/product/data_store_wise',
                    type: 'get',
                    data: {store_id:store_id, product_id:product_id},
                    success: function(response){
                        if(!response){
                            $('#create_price').show();
                            $('.price_update').val(null);
                            $('.product_price').val(null);
                            $('.product_discount').val(null);
                            //$('.product_vat_tax').val(null);
                            $('.product_quantity').val(null);
                            //$('.product_quantity_s').val(null);
                            $('.minimum_sell_unit').val(null);
                            $('#set_quantity').text("Set Quantity");
                            $('#set_quantity').attr('data-type',0);
                            $('.pp_id').val(null);             //price create



                        }else{
                            $('#create_price').show();
                            $('.price_update').val(1);
                            console.log(response);
                            let w_y=parseInt(response.warranty_months/12);
                            let w_m=parseInt(response.warranty_months%12);
                            //console.log("wy="+w_y);
                            $(".wy-"+w_y).prop("selected",true);
                            $(".wm-"+w_m).prop("selected",true);

                            let vat_tax_id=response.vat;
                            $(".vt-"+vat_tax_id).prop("selected",true);


                                let araTypes=response.item_offer;
                                let a=araTypes.split(",");
                                //console.log(a);
                                for(var i = 0; i < a.length; i++){
                                    $(".offer-"+a[i]).attr("checked", "checked");
                                }

                            $('.product_price').val(response.price);
                            $('.product_discount').val(response.discount);
                            $('.minimum_sell_unit').val(response.minimum_sell_unit);
                            $('.product_quantity').val(response.product_quantity);
                            //$('.product_quantity_s').val(response.quantity);
                            $('#set_quantity').text("Update Quantity");
                            $('#set_quantity').attr('data-type',1);    //price update
                            $('.pp_id').val(response.id);
                        }
                        // console.log(response);
                    }
                });
            }
        }

        function show_for_update(store_id,product_id){
            console.log(store_id, product_id);
        }


        // add quantity
        $(document).on('click','#set_quantity', function(){
            var id = $(this).attr('data-id');
            var type = $(this).attr('data-type');
            var pp_id = $('.pp_id').val();
            // console.log(id);

            if(type == 0){                 //create quantity
                $.ajax({
                    url: "/vendor/add_product_qty",
                    type: "GET",
                    data: {id:id},
                    success: function(response){
                        $('#addQtyModal').modal('show');
                        console.log(response);
                        $('.add_qty_body').html(response);
                    }
                });

            }else if(type == 1){             //update quantity
                $.ajax({
                    url: "/vendor/get_product_qty",
                    type: "GET",
                    data: {id:id,pp_id:pp_id},
                    success: function(response){
                        $('#addQtyModal').modal('show');
                        console.log(response);
                        $('.add_qty_body').html(response);
                    }
                });
            }
        });


        $(".js-live-data-search").select2({
            ajax: {
            url: "/vendor/product/search",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                // console.log(params.term);
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function (response) {
                // console.log(response);
                return {
                    results: response
                };
            },
            cache: true
            }
        });

    });
</script>

@endsection
