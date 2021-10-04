@extends('layouts.vendor')

@section('content')


    <div class="card">
        <div class="card-header">
            <h5>All Ready Added</h5>
        </div>
        <div class="card-body">
            <div class="row d-flex align-items-end p-3 justify-content-center">
                @foreach($productimages as $pi)
                    <div class="col-1">
                        <div class="card mb-0">
                            <div class="card-img-top">
                                <img style="max-width: 100%" src="{{$pImgLoc}}{{$pi->imagename}}" alt="">
                            </div>
                            <div class="d-flex justify-content-center pt-2">
                                <button type="button" data-id="{{$pi->id}}" class="btn btn-secondary btn-sm edit-btn" data-toggle="modal" data-target="#exampleModal">Edit</button>
                                {{-- <button class="btn btn-sm btn-secondary ml-1">Delete</button> --}}
                                <button type="button" onclick="deleted({{$pi->id}})" class="btn btn-danger btn-sm ml-1">Delete</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>+ Add More Image</h5>
                </div>
                <div class="card-body">
                    <form name="p_form" id="p_form" method="post" action="{{route('product.addmoreimage.save',[$id])}}" class="row" enctype="multipart/form-data">
                        @csrf

                        <table class="table">
                            <tbody class="image_add_table">
                                <tr>
                                    <td><input type="file" class="form-control" id="productimage" name="productimage[]"></td>
                                    <td><button type="button" class="btn btn-danger btn-remove" id="">Remove</button></td>
                                    <td><button type="button" class="btn btn-success btn-add" id="">Add</button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><input type="submit" class="btn btn-success"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>


        
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{route('vendor.detailimage.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="file" name="newimage" class="form-control">
                    <input type="hidden" name="id" class="modal_image_id">
                </div>
            
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
            </div>
        </div>
        </div>
    </div>


    @section('js')


    
<script>
    function deleted(id)
        {
        $.confirm({
            title: 'Are you sure?',
            content: 'This is Permanent Delete.',
            product: 'red',
            productAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Delete Now',
                    btnClass: 'btn-red',
                    action: function(){
                        window.location.href = '{{ route('vendor.productmoreimage.delete') }}/'+id;
                    }
                },
                close: function () {
                }
            }
        });
        }
        
        $(document).ready(function(){
            $(document).on('click', '.btn-add', function(){
                $('.image_add_table').append(
                    '<tr>'+
                    '<td><input type="file" class="form-control" id="productimage" name="productimage[]"></td>'+
                    '<td><button class="btn btn-danger btn-remove" id="btn-remove">Remove</button></td>'+
                    '<td><button type="button" class="btn btn-success" id="btn-add">Add</button></td>'+
                    '</tr>'
                )
            });

            $(document).on('click', '.btn-remove', function(){

                var tr = $('.image_add_table tr');
                if(tr.length<2){
                    alert("Last Row Is Not Removeable")
                }
                else{
                    $(this).closest('tr').remove();
                }
                
            });
        });

        $('.edit-btn').click(function(){
            var id = $(this).data('id');
            $('.modal_image_id').val(id);
        });
    </script>

@endsection
@endsection