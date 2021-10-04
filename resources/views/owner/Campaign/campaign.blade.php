@extends('layouts.owner')

@section('content')
@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                + Add New Campaign
                </button>
            </h5>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <form action="{{route('owner.campaigns.create')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Campaign Name" required>
                                    @error('name') <strong class="text-danger">{{$message}}</strong>@enderror
                                    <aks-file-upload></aks-file-upload>
                                    @error('aksfileupload') <strong class="text-danger">{{$message}}</strong>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Campaign Type</label>
                                    <select name="campaign_type" class="form-control">
                                        @foreach ($camp_types as $ct)
                                            <option value="{{$ct->id}}">{{$ct->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('campaign_type') <strong class="text-danger">{{$message}}</strong>@enderror
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Start Time</label>
                                            <input type="text" autocomplete="off" name="s_time" class="form-control form_datetime">
                                        </div>
                                        @error('s_time') <strong class="text-danger">{{$message}}</strong>@enderror
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">End Time</label>
                                            <input type="text" autocomplete="off" name="e_time" class="form-control form_datetime">
                                        </div>
                                        @error('e_time') <strong class="text-danger">{{$message}}</strong>@enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <p>
                                        <label for="amount">Delivery Days Range:</label>
                                        <input type="text" id="amount" name="delivery_info" readonly style="border:0; color:#f6931f; font-weight:bold; outline: none;">
                                    </p>
                                    <div id="slider-range"></div>
                                    @error('delivery_info') <strong class="text-danger">{{$message}}</strong>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" cols="30" rows="2" class="form-control"></textarea>
                                    @error('remarks') <strong class="text-danger">{{$message}}</strong>@enderror
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
                <h4>All Campaign</h4>
            </div>
            <div class="col-12">
                <div class="row justify-content-center align-items-end text-center">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Campaign Type</td>
                                <td>Image</td>
                                <td>Campaign Name</td>
                                <td>Start Time</td>
                                <td>End Time</td>
                                <td>Delivery Between</td>
                                <td>Remarks</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($campaigns as $key=>$c)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$c->get_campaign_type->name}}</td>
                                    <td><img src="{{asset('images')}}/campaigns/{{$c->image}}" alt="" class="mx-auto" style="width: 100px"></td>
                                    <td>{{$c->name}}</td>
                                    <td>{{$c->start_time}}</td>
                                    <td>{{$c->end_time}}</td>
                                    <td>{{$c->delivery_info}}Days</td>
                                    <td>{{$c->remarks}}</td>
                                    <td>
                                        <button type="button" data-id="{{$c->id}}" class="btn btn-secondary btn-xs edit-btn" data-toggle="modal" data-target="#editmodal">Edit</button>
                                        <a href={{route('owner.campaigns.edit_product',['id'=>$c->id])}} class="btn btn-info btn-xs">Edit Details</a>
                                        @if ($c->status == 1)
                                            <a href="{{route('owner.campaigns.status',['id'=>$c->id])}}" class="btn btn-xs btn-danger">Deactive</a>
                                        @else
                                            <a href="{{route('owner.campaigns.status',['id'=>$c->id])}}" class="btn btn-xs btn-success">Active</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                    <form action="{{route('owner.campaigns.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Update Image:</label>
                                <input type="file" name="newimage" class="form-control">
                                <input type="hidden" name="id" class="modal_image_id">
                            </div>
                            <div class="form-group">
                                <label for="">Campaign Type:</label>
                                <select name="campaign_type" class="form-control campaign_type">
                                    @foreach ($camp_types as $ct)
                                        <option value="{{$ct->id}}">{{$ct->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" class="form-control name" name="name">
                            </div>

                            <div class="form-group">
                                <label for="">Start Time</label>
                                <input type="text" class="form-control s_time form_datetime" name="s_time">
                            </div>

                            <div class="form-group">
                                <label for="">End Time</label>
                                <input type="text" class="form-control e_time form_datetime" name="e_time">
                            </div>

                            <div class="form-group">
                                <p>
                                    <label for="amount">Delivery Days Range:</label>
                                    <input type="text" id="amount_edit" name="delivery_info" readonly style="border:0; color:#f6931f; font-weight:bold; outline: none;">
                                </p>
                                <div id="slider-range_edit"></div>
                            </div>

                            <div class="form-group">
                                <label for="">Remarks</label>
                                <textarea name="remarks" cols="30" rows="2" class="form-control remarks"></textarea>
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

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $("aks-file-upload").aksFileUpload({
            fileUpload: "#uploadfile",
            dragDrop: true,
            maxSize: "90 GB",
            multiple: false,
            maxFile: 50
        });

    $(".form_datetime").datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });


    $(document).ready(function(){
        $('.edit-btn').click(function(){
            var id = $(this).data('id');
            $('.modal_image_id').val(id);
            $.ajax({
                url: '/owner/campaign_edit',
                type: 'get',
                data: {id:id},
                success: function(response){
                    // console.log(response);
                    $('.campaign_type').val(response.campaign_type);
                    $('.name').val(response.name);
                    $('.s_time').val(response.start_time);
                    $('.e_time').val(response.end_time);
                    $('.delivery_info').val(response.delivery_info);
                    $('.remarks').val(response.remarks);

                    var dinfo = response.delivery_info;
                    res = dinfo.split("-");

                    $( function() {
                        $( "#slider-range_edit" ).slider({
                            range: true,
                            min: 1,
                            max: 90,
                            values: [res[0],res[1]],
                            slide: function( event, ui ) {
                                $( "#amount_edit" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
                            }
                        });

                        $( "#amount_edit" ).val( "" + $( "#slider-range_edit" ).slider( "values", 0 ) +
                        "-" + $( "#slider-range_edit" ).slider( "values", 1 ) );
                    });
                }
            });
        });
    });

    $( function() {
        $( "#slider-range" ).slider({
        range: true,
        min: 1,
        max: 90,
        values: [1,7],
        slide: function( event, ui ) {
            $( "#amount" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
        }
        });
        $( "#amount" ).val( "" + $( "#slider-range" ).slider( "values", 0 ) +
        "-" + $( "#slider-range" ).slider( "values", 1 ) );
    });
  </script>

@endsection
