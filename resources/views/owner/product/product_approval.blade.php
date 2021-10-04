@extends('layouts.owner')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>Products Need To Approvals</h3>
        </div>

        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Vendor Name</th>
                        <th>Store Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>All <input type="checkbox" class="checkall"></th>
                    </tr>
                    <tbody id="approvalv_list">
                        @foreach ($products as $p)
                            <tr id="{{$p->id}}">
                                <td>{{$p->get_product_info->name}}</td>
                                <td>{{$p->get_product_info->get_vendor_name->email}}</td>
                                <td>{{$p->get_store_name->name}}</td>
                                <td>{{$p->price}}</td>
                                <td>{{$p->discount}}</td>
                                <td>
                                    @if($p->cur_status == 0)
                                        <span class="badge badge-info p-1">New</span>
                                    @else
                                        <span class="badge badge-warning p-1">Edited</span>
                                    @endif
                                </td>
                                <td><input type="checkbox" class="selectedId select_id-{{$p->id}}"></td>
                            </tr>

                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <button type="submit" class="btn btn-success px-5" onclick="submit_handle()">Approve</button>
                            </td>
                        </tr>
                    </tfoot>
                </thead>
            </table>
        </div>
    </div>

@endsection


@section('js')

    <script>
            $('.checkall').click(function () {
                $('.selectedId').prop('checked', this.checked);
            });

            $('.selectedId').change(function () {
                let check = ($('.selectedId').filter(":checked").length == $('.selectedId').length);
                $('.checkall').prop("checked", check);
            });


            function submit_handle(){
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
                    url : '/owner/price_approval',
                    type : 'post',
                    data : {data:data},
                    success : function(res){
                        if(res){
                            window.location.reload();
                        }
                    }
                });
            }



            // let container_list =
    </script>



@endsection
