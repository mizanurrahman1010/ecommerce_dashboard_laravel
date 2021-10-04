@extends('layouts.owner')

@section('content')
@section('css')
    <style>
        .aks-file-upload{
            border: 1px solid #333;
            margin-top: 20px;
        }
    </style>
@endsection
<div class="card">
    <div class="card-body">
        <div id="accordion" class="pb-3" style="border-bottom: 1px solid rgba(0,0,0,.1);">
            <h5 class="mb-0">
                <button class="btn btn-primary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                + Add New Campaign Type
                </button>
            </h5>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <form action="{{route('owner.campaign_types.create')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Campaign Type Name" required>
                                    @error('name') <strong class="text-danger">{{$message}}</strong>@enderror
                                    <aks-file-upload></aks-file-upload>
                                    @error('aksfileupload') <strong class="text-danger">{{$message}}</strong>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" id="" cols="30" rows="3" class="form-control"></textarea>
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
                <h4>All Campaign Type</h4>
            </div>
            <div class="col-12">
                <div class="row justify-content-center align-items-end text-center">
                    @foreach ($campaign_type as $ct)
                        <div class="col-2">
                            <img src="{{asset('images')}}/campaign_type/{{$ct->image}}" alt="" class="w-100">
                            <h6 class="py-1">{{$ct->name}}</h6>
                            <button type="button" data-id="{{$ct->id}}" class="btn btn-secondary btn-xs edit-btn" data-toggle="modal" data-target="#editmodal">Edit</button>
                            @if ($ct->status == 1)
                                <a href="{{route('owner.campaign_types.status',['id'=>$ct->id])}}" class="btn btn-xs btn-danger">Deactive</a>
                            @else
                                <a href="{{route('owner.campaign_types.status',['id'=>$ct->id])}}" class="btn btn-xs btn-success">Active</a>
                            @endif
                        </div>
                    @endforeach
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
                    <form action="{{route('owner.campaign_types.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Update Image:</label>
                                <input type="file" name="newimage" class="form-control">
                                <input type="hidden" name="id" class="modal_image_id">
                            </div>
                            <div class="form-group">
                                <label for="">Campaign Type:</label>
                                <input type="text" name="name" value="" class="form-control name">
                            </div>
                            <div class="form-group">
                                <label for="">Remarks:</label>
                                <textarea type="text" name="remarks" value="" class="form-control remarks"></textarea>
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
                url: '/owner/campaign_type_edit',
                type: 'get',
                data: {id:id},
                success: function(response){
                    // console.log(response);
                    $('.remarks').val(response.remarks);
                    $('.name').val(response.name);
                }
            });
        });
    });
  </script>

@endsection
