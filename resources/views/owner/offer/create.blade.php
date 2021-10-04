@extends('layouts.owner')
@section('content')
    <style>
        .text-center{
            text-align: left !important;
        }
    </style>
    <div class="card ml-5 mr-5">
        <div class="card-body">
            
            <div class="row mt-6">
                <div class="col-12">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <div class="d-flex">
                        <div class="p-2">
                            <h4>Add Offer Images</h4>
                        </div>
                        <div class="ml-auto p-2">
                            <a href="{{route('owner.offer.index')}}">List</a>
                        </div>
                    </div>
                    
                </div>
                <div class="col-12">
                    <div class="row justify-content-left align-items-end text-center">
                        <form action="{{route('owner.offer.image.save')}}" 
                                enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-6 offset-2">
                                    <div class="row">
                                        <?php 
                                            $defBtnText="Submit";$def_name="";$status_id=-1;$sort_id="";$route="";
                                            if(count($update_info) > 0){
                                                $defBtnText="Update";
                                                $def_name="disabled";$sort_id=$update_info["info"]->sort_id;
                                                $status_id=$update_info["info"]->status;
                                                ?>
                                                    <input name="update_id" type="hidden" value="{{$update_info['id']}}" />
                                                    <input name="update_img" type="hidden" value="{{$update_info['pid']}}" />
                                                <?php 
                                            }
                                        ?>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="" style="text-align: left;">
                                                    Name
                                                </label>
                                                <input class="form-control" name="name" <?=$def_name ?>/>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="" style="text-align: left;">
                                                    Status
                                                </label>
                                                <select class="form-control" name="status">
                                                    <option <?php if($status_id == 1): ?>selected<?php endif ?> value="1">Show</option>
                                                    <option <?php if($status_id == 2): ?>selected<?php endif ?> value="2">Hide</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="" style="text-align: left;">
                                                    Sort Id
                                                </label>
                                                <input class="form-control" name="sort_id" value="<?=$sort_id ?>" />
                                            </div>
                                        </div>    
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="" style="text-align: left;">
                                                    Current Offers
                                                </label>
                                                <select name="offer_id" class="form-control" required>
                                                    @if(count($update_info) <= 0)
                                                        <option value="0"></option>
                                                    @endif
                                                    @foreach($list as $val)
                                                        <option <?php if(!empty($update_info["id"]) && $update_info["id"] == $val->id): ?>selected<?php endif ?> value="{{$val->id}}">
                                                            {{$val->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="" style="text-align: left;">Offer Images</label>
                                                <input type="file" name="images[]" 
                                                    class="form-control" 
                                                    multiple="multiple" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-block btn-success">
                                                <?=$defBtnText ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <br>
                    <div class="col-sm-12 col-md-12 col-lg-8 pt-2" >
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
