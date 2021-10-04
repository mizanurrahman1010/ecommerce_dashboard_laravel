@extends('layouts.owner')

@section('content')


    <div class="col-lg-12">
        <div class="card card-info mb-0">
            <div class="card-header bg-secondary text-white">
                <h3 class="text-center">
                    Advanced Search
                </h3>
            </div>
            <div class="card-body">
                <div class = "col-sm-10 offset-sm-1">
                    <form action="{{route('owner.vendor_list')}}">
                        <?php
                        $status_id=0;
                        if(isset($_GET["StatusTypeId"]))
                            $status_id=$_GET["StatusTypeId"];
                        ?>
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <div class="row">
                                    <div class="col-sm-3 col-lg-3">
                                        <p style="margin:0;padding:2px;">Name:</p>
                                        <input name="name" id="name" class="form-control" placeholder="Enter your name" />
                                    </div>
                                    <div class="col-sm-3 col-lg-3">
                                        <p style="margin:0;padding:2px;">Phone Number:</p>
                                        <input name="phone_no" id="phone_no" class="form-control" placeholder="Enter phone No" />
                                    </div>
                                    <div class="col-sm-3 col-lg-3">
                                        <p style="margin:0;padding:2px;">Email:</p>
                                            <input name="email_no" id="email_no" class="form-control" placeholder="Enter email address" />
                                    </div>
                                    <div class="col-sm-3 col-lg-3">
                                        <p style="margin:0;padding:2px;">Status:</p>
                                        <select class="form-control" name="StatusTypeId" id="StatusTypeId">
                                            <option  <?php if($status_id == 0): ?>selected<?php endif; ?>  value="0">All</option>
                                            <option <?php if($status_id == 1): ?>selected<?php endif; ?> value="1">Active</option>
                                            <option <?php if($status_id == 2): ?>selected<?php endif; ?> value="2">InActive</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 " style="margin-top:10px;">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-sm btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>




<div class="card ml-5 mr-5 pt-0">
    <div class="card-header bg-secondary text-white">
        <h3 class="text-center">
            Vendor Record
        </h3>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <td><b>#</b></td>
                    <td><b>Name</b></td>
                    <td><b>Email</b></b></td>
                    <td><b>Mobile</b></b></td>
                    <td><b>Image</b></td>
                    <td><b>Stores</b></td>
                    <td><b>Status</b></td>
                    <td><b>Action</b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key=>$ven)
                    <?php
                    $status="Active"; $def_style="success";
                    if($ven->status == '2')
                    {
                        $def_style="danger";
                        $status="Inactive";
                    }
                    ?>
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$ven->name}}</td>
                        <td>{{$ven->email}}</td>
                        <td>{{$ven->phone}}</td>
                        <td>
                        <img class="" style="height: 60px;" src="{{Storage::disk('s3')->url(helperAwsLocation(3))}}{{$ven->image}}" alt="Vans">

                        </td>
                        
                        <td>
                            @foreach ($ven->get_stores as $store)
                                <span>{{$store->name}}</span><br>
                            @endforeach
                        </td>
                        <td>
                            <?php
                                if($ven->status == '1')
                                    echo "<button class='btn btn-sm btn-light' style='color:green;'  >Active</button>";
                                if($ven->status == '2')
                                    echo "<button class='btn btn-sm btn-light' style='color:red;'  >InActive</button>";
                            ?>
                        </td>
                        <td>
                            <a href="{{route('owner.as_vendor.login',['id'=>$ven->id])}}" target="__blank" class="btn btn-success btn-xs"></i>Login</i></a>
{{--                            <a href="{{ route('owner.vendor.create',['id'=>$ven->id]) }}" target="" class="btn btn-danger btn-xs">Edit</a>--}}
                            <a href="{{route('owner.vendor.vendorinfo_update',['id'=>$ven->id])}}" class="btn btn-danger btn-xs">Update</a>
                            <a href="{{route('owner.status_update',['id'=>$ven->id])}}" class="btn btn-{{$def_style}} btn-xs">{{$status}}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <br>
            <div class="col-sm-12 col-md-12 col-lg-8 pt-2" >
                {{$data->links()}}
            </div>
        </table>
    </div>
</div>

@endsection
