@extends('layouts.owner')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection
@section('content')

<div class="card">
	<div class="card-header">
        <h5>@if($od_status == 1)Pending @elseif($od_status == 2) Confirmed @elseif($od_status == 3) Processing @elseif($od_status == 0) All @else Delivered @endif Orders</h5>
    </div>
    <div class="card-body">
        <div class="row">

            <div class="col-8 offset-2 mb-2">
                {{-- <form action="{{route('owner.filter_orders')}}" method="get">
                    <div class="row">
                        <div class="col">
                            <label for="">Select Time Period</label>
                            <select name="period" id="" class="form-control">
                                <option value="all">All</option>
                                <option value="hour">Between 1 Hour</option>
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="week">Last 7 Days</option>
                                <option value="month">Last 30 Days</option>
                                <option value="year">Year</option>
                            </select>
                        </div>
                        <div class="col-5">
                            <label for="">&nbsp;</label><br>
                            <input type="submit" value="Filter" class="btn btn-success">
                        </div>
                    </div>
                </form> --}}
                <form action="{{route('owner.order.all')}}" method="get">
                    <div class="row">
                        @if($od_status == 0)
                            <div class="col">
                                <label for="">Order Status</label>
                                <select name="check_status" class="form-control">
                                    <option value="">All</option>
                                    <option value="1">Pending Order</option>
                                    <option value="2">Confirmed Order</option>
                                    <option value="3">Proccessed Order</option>
                                    <option value="4">Delivered Order</option>
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="check_status" value="{{$od_status}}">
                        @endif
                        <div class="col">
                            <label for="">Order No.</label>
                            <input type="text" name="order_no" placeholder="Order No" class="form-control">
                        </div>
                        <div class="col">
                            <label for="">Select Type</label>
                            <select name="type" class="form-control">
                                <option @if($type == 0) selected @endif value="">All</option>
                                <option @if($type == 1) selected @endif value="hours">Hours</option>
                                <option @if($type == 2) selected @endif value="days">Days</option>
                                <option @if($type == 3) selected @endif value="months">Months</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="">Enter Number</label>
                            <input type="text" placeholder="Enter Number" class="form-control" name="value">
                        </div>
                        <div class="col-1">
                            <label for="">&nbsp;</label><br>
                            <input type="submit" value="Filter" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>
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
                        <tbody>

                            @foreach ($orders as $order)

                                <tr>
                                    <td class="text-left t-order">
                                        <h5>
                                            <a class="text-primary" href="#">{{$order->id}}</a>
                                        </h5>
                                    </td>

                                    <td class="text-left">
                                        <?php $date = new DateTime($order->created_at); ?>
                                        <p class="mb-0"><b>Date:</b> {{$date->format('d M Y')}}</p>
                                        <p class="mb-0"><b>Time:</b> {{$date->format('H:i A')}}</p>
                                        <p class="mb-0" style="white-space: pre-wrap;" ><b>Address:</b> {{$order->address}}</p>

                                        @if ($order->note !== null)
                                            <p class="mb-0" style="white-space: pre-wrap;" ><b>Note:</b> {{$order->note}}</p>
                                        @endif
                                        <p class="mb-0" style="white-space: pre-wrap;" ><b>Phone:</b> {{$order->mobile}}</p>
                                        <p class="mb-0" style="white-space: pre-wrap;" ><b>Email:</b> {{$order->get_user_info->email}}</p>
                                        <p class="mb-0" style="white-space: pre-wrap;" ><b>Name:</b> {{$order->get_user_info->name}}</p>
                                    </td>

                                    <td class="t-pro">

                                        <div class="t-content">
                                            @foreach ($order->get_order_details as $od)
                                                <p class="t-heading mb-1"><a href="">{{$od->get_product_name->name}}</a> ({{$od->quantity}} x {{$od->price}})</p>
                                            @endforeach
                                        </div>
                                    </td>

                                    <td class="t-price">{{$order->total}}</td>

                                    <td class="t-total px-3">
                                        <div class=" d-flex flex-wrap">
                                            <div class="col-12 mb-3">
                                                @if($order->status == 1)
                                                    {{-- @php $btn_label = "Confirm" @endphp --}}
                                                    <button class="btn btn-success" onclick="delivered({{$order->id}},{{$order->status}})">Confirm</button>
                                                @elseif($order->status == 2)
                                                    <button class="btn btn-success" onclick="delivered({{$order->id}},1)">Confirm</button>
                                                    <button class="btn btn-success" onclick="delivered({{$order->id}},{{$order->status}})">Process</button>
                                                    @php $btn_label = "Process" @endphp
                                                @elseif($order->status == 3)
                                                    {{-- @php $btn_label = "Delivered" @endphp --}}
                                                    <button class="btn btn-success" onclick="delivered({{$order->id}},2)">Process</button>
                                                    <button class="btn btn-success" onclick="delivered({{$order->id}},{{$order->status}})">Delivered</button>
                                                @else
                                                    {{-- @php $btn_label = "Product Is Delivered" @endphp --}}
                                                    <h6>Product Is Delivered</h6>
                                                @endif

                                            </div>
                                            <div class="col-12">
                                                <a class="btn btn-warning"  href="{{route('invoice',['id'=>$order->id])}}" >View Invoice</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach ($order->get_order_log as $ool)
                                            @if($ool->status_id == 2)
                                                @php $order_status_name =  "Confirmed" @endphp
                                            @elseif($ool->status_id == 3)
                                                @php $order_status_name =  "Processed" @endphp
                                            @else
                                                @php $order_status_name =  "Delivered" @endphp
                                            @endif

                                            <b>{{$order_status_name}}:</b> {{$ool->created_at->diffForHumans()}}
                                            <b>Message: {{$ool->message}}</b> <br>
                                        @endforeach
                                        @if($order->created_at)
                                            <b>Order:</b> {{$order->created_at->diffForHumans()}} <br>
                                        @endif
                                    </td>
                                </tr>

                                @endforeach
                        </tbody>
                    </table>
                </div>

                {!! $orders->links() !!}
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
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <input type="text" class="form-control message" name="message" placeholder="Message">
                                </div>
                            </div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
    function delivered(id,cu_status){

        // var cu_status = $(this).attr('data-id');
        // console.log(cu_status);
        if(cu_status == 2){
            var title = "Start Processing!";
            var content = "If you click start process that means product is start processing";
            var text = "processing Confirm";
            var location = "{{ route('owner.order.makeprocessing') }}/"+id;
        }
        else if(cu_status == 3){
            var title = "Delivery Confirmation!";
            var content = "If you click delivered that means product delivered successsully";
            var text = "Delivery Confirm";
            var location = "{{ route('owner.order.makedelivered') }}/"+id;
        }

        if(cu_status == 2 || cu_status == 3){
            $.confirm({
            title: title,
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label>Enter something here</label>' +
                '<input type="text" placeholder="Message" name="message" class="con_message form-control" required />' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: text,
                    btnClass: 'btn-blue',
                    action: function () {
                        var con_message = this.$content.find('.con_message').val();
                        if(!con_message){
                            $.alert('Write Message!!!');
                            return false;
                        }
                        // $.alert('Your name is ' + name);
                        $.ajax({
                            url : location,
                            data : {message:con_message},
                            success : function(res){
                                console.log(res);
                                if(res){
                                    window.location.reload();
                                }
                            }
                        });
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });


        }else if(cu_status == 1){   //when confirming
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

    $('.checkall').click(function () {
        $('.selectedId').prop('checked', this.checked);
    });

    $(document).on('change','.selectedId',function () {
        let check = ($('.selectedId').filter(":checked").length == $('.selectedId').length);
        $('.checkall').prop("checked", check);
    });


    function submit_handle(){

        var con = confirm("Are You Sure?");
        if(con == true){
            message = $('.message').val();
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
                data : {data:data,cur_order_id:cur_order_id,message:message},
                success : function(res){
                    if(res){
                        window.location.reload();
                    }
                    console.log(res);
                }
            });
        }
    }


</script>
@endsection
