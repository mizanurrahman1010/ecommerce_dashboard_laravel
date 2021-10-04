@extends('layouts.vendor')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <a href="{{route('vendor.product.index')}}" class="btn btn-primary px-5">Back</a>
                <h5 class="ml-4 text-center">Filtered Products</h5>
            </div>
            
            <form action="{{route('vendor.product.filter')}}" method="post" id="search_form">
                @csrf
                <div class="col-12 px-0 d-flex flex-wrap">
                    <div class="form-group col-4">
                        <label>Category:</label>
                        <select class="category_id form-control" name="category_id" id="categorydropdown">
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
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Store Id</th>
                        <th>Add Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="product_table">
                    @foreach ($products as $p)
                    <tr>
                        <td>
                            <img style="max-width:100px;" src="{{asset('images')}}/productimg/{{$p->image}}" alt="">
                        </td>
                        <td>{{$p->name}}</td>
                        <td>{{$p->price}}</td>
                        <td>{{$p->store_id}}</td>
                        <td><a href="{{route('product.addmoreimage',$p->id)}}" class="btn btn-primary mr-3">Add Image</a></td>
                        {{-- <td><a href="product/addmoreimage/{{$p->id}} " class="btn btn-primary mr-3">Add Image</a></td> --}}
                        <td>
                            <div class="d-flex">
                                <a href="{{route('product.edit',[$p->id])}}" class="btn btn-primary mr-3"><i class="fadeIn animated bx bx-edit-alt"></i></a>
                                <button type="button" onclick="deleted({{$p->id}})" class="btn btn-danger"><i class="fadeIn animated bx bx-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                   
               
                
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">{!! $products->links() !!}</td>
                    </tr>
                </tfoot>
              
            </table>
        </div>
    </div>


</div>

@endsection



@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
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


    $('.category_id').val({{$scat}});
    $(document).ready(function(){
    
    // Initialize select2
    $("#categorydropdown, #subcategorydropdown, #subsubcategorydropdown").select2();
    });
</script>
@endsection
