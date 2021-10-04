@extends('layouts.owner')

@section('content')
@section('css')

    <style>
        .addbutton{
            position: fixed;
            right: 0;
            bottom: 50%;
        }
        .add_more_row{
            padding: 15px 20px;
            font-size: 15px;
        }
    </style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
    <div class="card">
        <div class="card-header">
            <h3>Update <span style="color: #0069D9;">{{$campaign_name->name}}</span> Details</h3>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-6 offset-3 alert alert-danger alert-dismissible fade notunique" style="display: none;" role="alert">
                    <strong>Found Non Unique Store And Product</strong> Check Below.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="col-4 offset-4 mb-3">
                    <label for="">Campaign Name: </label>
                    <select name="campaign" id="" class="form-control campaign_id">
                        <option value="{{$campaign_name->id}}">{{$campaign_name->name}}</option>
                    </select>
                </div>

                {{-- product pricing  --}}
                <div class="col-12">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <td>Store</td>
                                <td>Product Name</td>
                                <td>Price</td>
                                <td>Discount</td>
                                <td>Cashback</td>
                                <td>Remove</td>
                            </tr>
                        </thead>
                        <tbody class="product_add_to_campaign">
                            @foreach ($products as $i=>$pro)
                                <tr class="tr_camp" data-id="<?=$i+1 ?>">
                                    <td>
                                        <input type="hidden" class="row-id-{{$i+1}}" value="{{$pro->id}}">
                                        <select name="store" class="form-control store sid-<?=$i+1 ?>" style="width: 150px;">
                                            <option value="{{$pro->store_id}}">{{$pro->get_store_name->name}}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="product_name" class="form-control product_name pid-<?=$i+1 ?>" id="product_select" style="width: 150px;">
                                            <option value="{{$pro->product_id}}">{{$pro->get_product_name->name}}</option>
                                        </select>
                                    </td>

                                    <td><input type="text" value="{{$pro->price}}" class="form-control price price-<?=$i+1 ?>" disabled="true"></td>
                                    <td><input type="text" value="{{$pro->discount}}" class="form-control discount dis-<?=$i+1 ?>"></td>
                                    <td><input type="text" value="{{$pro->cashback}}" class="form-control cashback cb-<?=$i+1 ?>"></td>
                                    <td><button class="btn btn-danger btn-sm btn-remove"><i class="fas fa-trash-alt"></i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <button onclick="btnSubmitHandler()" class="btn btn-sm btn-primary px-5">Update</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="6" id="input_max_row"/>
    <div class="addbutton">
        <button class="btn btn-success btn-sm add_more_row">+</button>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>

        // function get_price(){
        //     console.log("working");
        // }

        // submit
        function btnSubmitHandler(){
            $('.validation_error').removeClass('show');
            $('.validation_errors').html('');
            var list=[];
            var campaign_id = $('.campaign_id').val();
            $(".tr_camp").each(function(){
                var id=$(this).attr("data-id");
                var sid=$(".sid-"+id).val();
                var pid=$(".pid-"+id).val();
                var price=$(".price-"+id).val();
                var dis=$(".dis-"+id).val();
                var cb=$(".cb-"+id).val();
                var row_id = $(".row-id-"+id).val();

                if(sid && pid && price){
                    var obj={
                        sid:sid,
                        pid:pid,
                        price:price,
                        dis:dis,
                        cb:cb,
                        row_id:row_id
                    }
                    list.push(obj);
                }
            });

            if(campaign_id && list){
                list = JSON.stringify(list);
                // console.log(list);
                $.ajax({
                    url : 'product_update_to_campaign',
                    type : 'post',
                    data : {list:list,campaign_id:campaign_id},
                    success : function(response){

                        // console.log(response);
                        if(response == 'success'){
                            window.location.reload();
                        }
                        else{
                            $('.notunique').show().addClass('show');
                        }
                    }
                });
            }
        }


        // store check
        $(document).on('mouseenter', '.store', function() {
            $(this).select2({
                minimumInputLength: 2,
                ajax: {
                url: "/owner/search_store",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                    };
                },
                processResults: function (response) {
                    // console.log(response);
                    // get_price();
                    // $(".brand").prop("disabled", false);
                    return {
                        results: response,
                    };


                },
                }
            });
        });

        $(document).on('mouseenter','.product_name', function() {
            var thisStore = $(this).parent().parent().children().children('.store');

            $(this).select2({
                minimumInputLength: 2,
                ajax: {
                    url: "/owner/product_name",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        var k = thisStore.val();
                        // console.log(k);
                        return {
                            searchTerm: params.term,
                            store: k,
                        };
                    },
                    processResults: function (response) {
                        // get_price();
                        return {
                            results: response
                        };
                    },
                },
            });
        });


        $(document).on('change','#product_select', function(){
            var thisStore = $(this).parent().parent().children().children('.store').val();
            var price = $(this).parent().parent().children().children('.price');
            var discount = $(this).parent().parent().children().children('.discount');
            var cashback = $(this).parent().parent().children().children('.cashback');
            var product = $(this).val();
            var status = 0;
            // console.log(thisStore,product);
            get_price(thisStore, price, product, discount,cashback);
        })


        $(document).on('change','.store', function(){
            var product = $(this).parent().parent().children().children('.product_name').val();
            var price = $(this).parent().parent().children().children('.price');
            var discount = $(this).parent().parent().children().children('.discount');
            var cashback = $(this).parent().parent().children().children('.cashback');
            var thisStore = $(this).val();
            // console.log(thisStore,product);

            get_price(thisStore, price, product, discount,cashback);
        })


        function get_price(thisStore, price, product,discount,cashback){
            // console.log(thisStore,product);
            if(thisStore != null && product != null){
                $.ajax({
                    url: '/owner/get_price',
                    data: {store: thisStore, product:product},
                    type: 'get',
                    success: function(response){
                        if(response != 'product_not_found'){
                            $(price).val(response);
                            $(discount).attr('disabled', false);
                            $(cashback).attr('disabled', false);
                        }
                        else{
                            $(price).val(0);
                            $(discount).val('');
                            $(discount).attr('disabled', true);
                            $(cashback).val('');
                            $(cashback).attr('disabled', true);
                        }
                    }
                });
            }
        }

        $(document).ready(function(){
            $('.add_more_row').click(function(){
                var max=$("#input_max_row").val();
                $('.product_add_to_campaign').append(
                    '<tr class="tr_camp" data-id="'+max+'">'+
                        '<td>'+
                            '<input type="hidden" class="row-id-'+max+'">'+
                            '<select name="store" class="form-control store sid-'+max+'" style="width: 150px;"></select>'+
                        '</td>'+
                        '<td>'+
                            '<select name="product_name" class="form-control product_name pid-'+max+'" id="product_select" style="width: 150px;"></select>'+
                        '</td>'+

                        '<td><input type="text" class="form-control price price-'+max+'" disabled="true"></td>'+
                        '<td><input type="text" class="form-control discount dis-'+max+'" disabled="true"></td>'+
                        '<td><input type="text" class="form-control cashback cb-'+max+'" disabled="true"></td>'+
                        '<td><button class="btn btn-danger btn-sm btn-remove"><i class="fas fa-trash-alt"></i></button></td>'+
                    '</tr>'
                );
                max++;
                $("#input_max_row").val(max);
            });


            $(document).on('click', '.btn-remove', function(){
                $(this).closest('tr').remove();
            });
        });




    </script>

@endsection
