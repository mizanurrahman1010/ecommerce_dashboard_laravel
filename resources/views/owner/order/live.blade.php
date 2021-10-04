@extends('layouts.owner')
@section('css')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css"> --}}
@endsection
@section('content')

<div class="card">
	<div class="card-header">
        <h5>Live Orders</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 px-1">
                <style media="screen">
                    @media(max-width: 768px) {

                        th.t-price,
                        th.t-order,
                        td.t-order,
                        td.t-price {
                            display: none;
                        }
                        li.list-inline-item.qty{
                          display: none !important;
                        }
                    }
                </style>

                <div class="cart-table table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="t-order">Order no.</th>
                                <th class="t-pro text-left">Date & Address</th>
                                <th class="t-pro text-left">Products <br>(Quantity x Price)</th>
                                <th class="t-price">total</th>
                                <th class="t-total">Action</th>
                                <th>Status Log</th>
                            </tr>
                        </thead>
                        <tbody id="live_order">

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="confirm_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Check All Product And Confirm</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Qty X Price</th>
                                    <th>Total</th>
                                    <th><input type="checkbox" class="checkall"> All</th>
                                    <input type="hidden" class="cur_order_id">
                                </thead>
                                <tbody class="modal_table_body" id="approvalv_list">

                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" onclick="submit_handle()" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection


@section('js')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script> --}}
<script>

    $('.checkall').click(function () {
        $('.selectedId').prop('checked', this.checked);
    });

    $(document).on('change','.selectedId',function () {
        let check = ($('.selectedId').filter(":checked").length == $('.selectedId').length);
        $('.checkall').prop("checked", check);
    });


    function submit_handle(){
        var cur_order_id = $('.cur_order_id').val();
        let list = [];
        $("#approvalv_list tr").each(function () {
            let tr_id = $(this).attr("id");
            if (typeof tr_id != "undefined") {
                if ($(".select_id-" + tr_id).is(":checked")) {
                    list.push(tr_id);
                }
            }
        });
        // console.log(list);
        var data = JSON.stringify(list);
        console.log(data);

        $.ajax({
            url : '/owner/order_detail_approval',
            type : 'post',
            data : {data:data,cur_order_id:cur_order_id},
            success : function(res){
                if(res){
                    // window.location.reload();
                    $('#tr_'+cur_order_id).remove();
                    $('#confirm_modal').modal('hide');
                }
                // console.log(res);
            }
        });
    }


</script>

{{-- pusher call  --}}
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script>
    var pusher = new Pusher('{{env("MIX_PUSHER_APP_KEY")}}', {
        cluster: '{{env("PUSHER_APP_CLUSTER")}}',
        encrypted: true
    });

    // var link = "{{route('owner.order.all')}}";

    var channel = pusher.subscribe('order-channel');
    channel.bind('App\\Events\\Order', function(data) {
        // alert(data.customer_name);
        var invoice_link = "/invoice/"+data.id;
        console.log(data);
        $('#live_order').append(
            '<tr id="tr_'+data.id+'">'+
                '<td class="text-left t-order">'+
                    '<h5>'+
                        '<a class="text-primary" href="#">'+data.id+'</a>'+
                    '</h5>'+
                '</td>'+
                '<td class="text-left">'+
                    '<p class="mb-0" style="white-space: pre-wrap;" ><b>Address:</b>'+data.address+'</p>'+
                    '<p class="mb-0" style="white-space: pre-wrap;" ><b>Note:</b>'+data.note+'</p>'+
                    '<p class="mb-0" style="white-space: pre-wrap;" ><b>Phone:</b>'+data.mobile+'</p>'+
                    '<p class="mb-0" style="white-space: pre-wrap;" ><b>Name:</b>'+data.customer_name+'</p>'+
                '</td>'+
                '<td class="t-pro">'+
                '<div class="t-content">'+data.cart+'</div>'+
                '</td>'+
                '<td class="t-price">'+data.total+'</td>'+
                    '<td class="t-total px-3">'+
                    '<div class=" d-flex flex-wrap">'+
                        '<div class="col-12 mb-3">'+
                            '<button class="btn btn-success" onclick="delivered('+data.id+',1)">Confirm</button>'+
                        '</div>'+
                        '<div class="col-12">'+
                            '<a class="btn btn-warning" target="__blank" href="'+invoice_link+'" >View Invoice</a>'+
                        '</div>'+
                    '</div>'+
                '</td>'+
                '<td>'+
                '</td>'+
            '</tr>'
        );
    });


    function delivered(id,cu_status){
        if(cu_status == 1){   //when confirming
            $('.cur_order_id').val(id);
            var data = '';
            $.ajax({
                url : '/owner/get_product_detail',
                type : 'get',
                data : {id:id},
                success : function(response){
                    $.each(response, function(key, value){
                        key = key+1;
                        data += '<tr id="'+value.id+'">'+
                                    '<td>'+ key +'</td>'+
                                    '<td>'+value.get_product_name.name+'</td>'+
                                    '<td>'+ value.quantity +' X '+ value.price +'</td>'+
                                    '<td>'+value.quantity*value.price+'</td>'+
                                    '<td><input type="checkbox" class="selectedId select_id-'+value.id+'"> </td>'+
                                '</tr>';
                    });
                    $('.modal_table_body').html(data);
                    $('#confirm_modal').modal('show');
                    console.log(response);
                }
            });

        }
    }
</script>
@endsection
