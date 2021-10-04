@extends('layouts.vendor')
@section('css')

<style>

</style>
@endsection
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <a href="{{route('vendor.dashboard')}}" class="btn btn-primary px-5 mr-3">Back</a>
                <h5>All Products Product</h5>

            </div>
            <form action="{{route('vendor.product.filter')}}" method="get" id="search_form">

                {{-- @csrf --}}
                <div class="col-12 px-0 d-flex flex-wrap">
                    <div class="form-group col-4">
                        <label>Category:</label>
                        <select name="category_id" id="categorydropdown" class="form-control">
                            <option value="">Select category</option>
                            @foreach ($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        <small id="category_id_error" class="form-text text-danger font-weight-bold"></small>
                    </div>

                    <div class="form-group col-4">
                        <label>Sub Category:</label>
                        <select class="form-control" name="sub_category_id" id="subcategorydropdown">
                        <option value="">select</option>
                        </select>
                        <small id="sub_category_id_error" class="form-text text-danger font-weight-bold"></small>
                    </div>

                    <div class="form-group col-3">
                        <label>Sub Sub Category:</label>
                        <select class="form-control" name="sub_sub_category_id" id="subsubcategorydropdown">
                            <option value="">select</option>
                        </select>
                        <small id="sub_sub_category_id_error" class="form-text text-danger font-weight-bold"></small>
                    </div>

                    <div class="col-1 form-group">
                        <label for="">Search</label>
                        <input type="submit" class="form-control btn btn-success" value="Filter">
                    </div>
                </div>
            </form>
        </div>


      <div class="card-body">
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Info</th>
                        <th>Add Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="product_table">
                    @foreach ($products as $p)
                    <tr>
                        <td>
                            <img style="max-width:100px;" src="{{$data['imgPUrl']}}{{$p->image}}" alt="">
                        </td>
                        {{-- <td></td> --}}
                        {{-- <td>{{$p->store_id}}</td> --}}
                        <td>
                            Product Name: {{$p->name}} <br>
                            Department: {{$p->department_id > 0 ? $p->get_department->name:''}} <br>
                            <span class="d-flex"> Colors:
                            @foreach ($p->get_colors as $p_colors)
                                 <div class="d-flex mx-2" style="width: 20px;height: 20px; background-color: {{$p_colors->name}}"></div> {{$p_colors->name}}
                            @endforeach </span>
                            Sizes:
                            @foreach ($p->get_sizes as $p_sizes)
                                {{$p_sizes->name}} @if(!$loop->last),@endif
                            @endforeach
                        </td>
                        {{-- <td>

                            @foreach ($p->get_price_store_wise as $p_price)
                                Store Name: {{$p_price->get_store_name->name}} <br>
                                Price: {{$p_price->price}} <br>
                                Discount: {{$p_price->discount}} <br>
                                <button data-id="{{$p_price->id}}" class="btn btn-xs btn-success update_price">Update Price</button>
                                <button data-id="{{$p_price->id}}" class="btn btn-xs btn-primary update_qty">Check Qty</button>

                                @if(!$loop->last)
                                    <hr class="my-1">
                                @endif
                            @endforeach

                        </td> --}}
                        {{-- <td><a href="{{route('product.set_price',['p_id'=>$p->id])}}" class="btn btn-info mr-3 btn-xs">Set Price</a></td> --}}
                        <td><a href="{{route('product.addmoreimage',$p->id)}}" class="btn btn-primary btn-xs mr-3">Add Image</a></td>
                        {{-- <td><a href="product/addmoreimage/{{$p->id}} " class="btn btn-primary mr-3">Add Image</a></td> --}}
                        <td>
                            <div class="d-flex">
                                <a href="{{route('product.edit',[$p->id])}}" class="btn btn-primary mr-3 btn-xs"><i class="fadeIn animated bx bx-edit-alt"></i></a>
                                <button type="button" onclick="deleted({{$p->id}})" class="btn btn-danger btn-xs"><i class="fadeIn animated bx bx-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">{{ $products->links() }}</td>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>
</div>


    <!-- Price Update Modal -->
    <div class="modal fade" id="updatePriceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Product Price</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{route('product.price_update.store_wise')}}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="pp_id" class="pp_id">
                    <div class="form-group">
                        <label for="">Price</label><br>
                        <input type="text" class="form-control price" placeholder="Price" name="price">
                    </div>
                    <div class="form-group">
                        <label for="">Discount(%)</label><br>
                        <input type="text" placeholder="Discount Percentage" class="form-control discount" value="0" name="discount">
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        </div>
    </div>


    <!-- color and size wise quantity -->
    <div class="modal fade" id="updateQtyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Qty</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{route('product.qty_update.store_wise')}}" method="post">
                @csrf
                <input type="hidden" class="current_pp_id" name="current_pp_id">
                <div class="modal-body update_qty_body">

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        </div>
    </div>


@endsection



@section('js')
<script>


    //update price store wise

    $(document).ready(function(){
        $(document).on('click','.update_price', function(){
            var id = $(this).data('id');
            // console.log(id);

            $.ajax({
                url: "/vendor/get_product_price_store_wise",
                type: "GET",
                data: {id:id},
                success: function(response){
                    $('.pp_id').val(response.id);
                    $('.price').val(response.price);
                    $('.discount').val(response.discount);
                    $('#updatePriceModal').modal('show');
                }
            });

        });
    });


    // update quantoty

    $(document).ready(function(){
        $(document).on('click','.update_qty', function(){
            var id = $(this).data('id');
            // console.log(id);

            $.ajax({
                url: "/vendor/get_product_qty",
                type: "GET",
                data: {id:id},
                success: function(response){
                    // $('.pp_id').val(response.id);
                    // $('.price').val(response.price);
                    $('.current_pp_id').val(id);
                    $('#updateQtyModal').modal('show');

                    console.log(response);
                    $('.update_qty_body').html(response);
                }
            });

        });
    });



    //delete
  function deleted(id)
        {
        $.confirm({
            name: 'Are you sure?',
            content: 'This is Permanent Delete.',
            product: 'red',
            productAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Delete Now',
                    btnClass: 'btn-red',
                    action: function(){
                        window.location.href = '{{ route('vendor.product.delete') }}/'+id;
                    }
                },
                close: function () {
                }
            }
        });
        }


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


        $(document).ready(function(){

        // Initialize select2
        $("#categorydropdown, #subcategorydropdown, #subsubcategorydropdown").select2();
        });

//filter

    // $('#search_form').on('submit', function(event) {
    //     event.preventDefault();
    //     var myformData = new FormData(this);


    //     var tabledata = '';
    //     $.ajax({
    //         type: "POST",
    //         processData: false,
    //         contentType: false,
    //         cache: false,
    //         data: myformData,
    //         url: "/vendor/product/filter",

    //         success: function(response) {
    //             $.each(response, function(key, value) {

    //                 tabledata += '<tr>'+
    //                     '<td>'+
    //                     '</td>'+
    //                     '<td>' + value.name + '</td>'+
    //                     '<td>'+value.price+'</td>'+
    //                     '<td>'+value.store_id+'</td>'+
    //                     '<td><a href="{{route('product.addmoreimage')}}/'+value.id+'" class="btn btn-primary mr-3">Add Image</a></td>'+

    //                     '<td>'+
    //                     '<div class="d-flex">'+
    //                     '<a href="" class="btn btn-primary mr-3"><i class="fadeIn animated bx bx-edit-alt"></i></a>'+
    //                     '<button type="button" class="btn btn-danger"><i class="fadeIn animated bx bx-trash-alt"></i></button>'+
    //                     '</div>'+
    //                     '</td>'+
    //                 '</tr>';
    //             });


    //             $('.product_table').html(tabledata);
    //         },
    //         error: function(error) {

    //             $("#sina-alert").addClass( "alert-danger" ).text("wron input").show('slow');
    //             window.setTimeout(function() {
    //                 $("#sina-alert").hide("slow").removeClass( "alert-danger" ).text("");
    //             }, 2000);

    //           $('#name_error').text(error.responseJSON.errors.name);

    //           $("html, body").animate({	scrollTop: 0}, 300);

    //         }
    //     });
    // });
</script>
@endsection
