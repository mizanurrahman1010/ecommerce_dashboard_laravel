@extends('layouts.owner');

@section('css')
    <style>
        .aks-file-upload{
            border: 1px solid #333;
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')

    <div class="col-lg-12">
        <div class="card card-info mb-0">
            <div class="card-header bg-secondary text-white">
                <h3 class="text-center">
                    Brand Search
                </h3>
            </div>
            <div class="card-body">
                <div class = "col-sm-10 offset-sm-1">
                    <form action="{{route('owner.brand.index')}}">
                        <?php
                        $status_id=0;
                        if(isset($_GET["StatusTypeId"]))
                            $status_id=$_GET["StatusTypeId"];
                        ?>
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <div class="row">
                                    <div class="col-sm-3 col-lg-3">
                                        <p style="margin:0;padding:2px;">Brand Name:</p>
                                        <input name="name" id="name" class="form-control" placeholder="Enter brand name" />
                                    </div>
                                    <div class="col-sm-3 col-lg-3">
                                        <p style="margin:0;padding:2px;">Status:</p>
                                        <select class="form-control" name="StatusTypeId" id="StatusTypeId">
                                            <option  <?php if($status_id == 0): ?>selected<?php endif; ?>  value="0">All</option>
                                            <option <?php if($status_id == 1): ?>selected<?php endif; ?> value="1">Active</option>
                                            <option <?php if($status_id == 2): ?>selected<?php endif; ?> value="2">InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-lg-3">
                                        <div class="row">
                                            <div class="col-sm-3"><BR>
                                                <button type="submit" class="btn btn-m btn-primary">Search</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
{{--                        <div class="row">--}}
{{--                            <div class="col-sm-12 " style="margin-top:10px;">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-sm-3">--}}
{{--                                        <button type="submit" class="btn btn-sm btn-primary">Search</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>



    <div class="card ml-5 mr-5">
        <div class="card-body">
            <div id="accordion" class="pb-3" style="border-bottom: 1px solid rgba(0,0,0,.1);">
                <h5 class="mb-0">
                    <button class="btn btn-primary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    + Add New Brand
                    </button>
                </h5>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <form action="{{route('owner.brand.store')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-4 offset-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" name="brand_name" class="form-control" placeholder="Brand Name" required>
                                        @error('brand_name') <strong class="text-danger">{{$message}}</strong>@enderror
                                        <aks-file-upload></aks-file-upload>
                                        @error('aksfileupload') <strong class="text-danger">{{$message}}</strong>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <textarea name="descriptions" id="" cols="30" rows="3" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <input type="submit" class="btn btn-block btn-success">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <h4>All Brands</h4>
                </div>
                <div class="col-12">
                    <div class="row justify-content-center align-items-end text-center">
                        @foreach ($brands as $brand)
                            <?php
                            $status="Active"; $def_style="success";
                            if($brand->status == '2')
                            {
                                $def_style="danger";
                                $status="Inactive";
                            }
                            ?>
                            <div class="col-2">
                                <img src="{{Storage::disk('s3')->url(helperAwsLocation(4))}}{{$brand->image}}" alt="" class="w-100">
                                <h6 class="py-1">{{$brand->name}}</h6>
                                <button type="button" data-id="{{$brand->id}}" class="btn btn-secondary btn-sm edit-btn" data-toggle="modal" data-target="#editmodal">Edit</button>
                                <a href="{{route('owner.brand.delete',['id'=>$brand->id])}}" class="btn btn-danger btn-xs">Delete</a>
                                <a href="{{route('owner.brand.status_update',['id'=>$brand->id])}}" class="btn btn-{{$def_style}} btn-xs">{{$status}}</a>
                            </div>

                        @endforeach

                    </div>
                    <br>
                    <div class="col-sm-12 col-md-12 col-lg-8 pt-2" >
                        {{$brands->links()}}
                    </div>
                </div>
            </div>



            <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="{{route('owner.brand.edit')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Update Image</label>
                                <input type="file" name="newimage" class="form-control">
                                <input type="hidden" name="id" class="modal_image_id">
                            </div>
                            <div class="form-group">
                                <label for="">Brand Name</label>
                                <input type="text" name="brand_name" value="" class="form-control brand_name">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea type="text" name="description" value="" class="form-control description"></textarea>
                            </div>

                        </div>

                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                    </div>
                </div>
                </div>
        </div>
    </div>

@endsection


@section('js')

  <script>
      $("aks-file-upload").aksFileUpload({
        fileUpload: "#uploadfile",
        dragDrop: true,
        maxSize: "90 GB",
        multiple: true,
        maxFile: 50
    });


    $(document).ready(function(){
        $('.edit-btn').click(function(){
            var id = $(this).data('id');
            $('.modal_image_id').val(id);
            $.ajax({
                url: '/owner/brand/get_info',
                type: 'get',
                data: {id:id},
                success: function(response){
                    console.log(response);
                    $('.description').val(response.descriptions);
                    $('.brand_name').val(response.name);
                    $('.image').val(response.image);
                }
            });
        });
    });
  </script>

@endsection
