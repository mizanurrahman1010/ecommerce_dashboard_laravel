@extends('layouts.vendor')


@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        @isset($current)
            <a href="{{route('vendor.store.create')}}" class="btn btn-xs btn-primary">+ Create New</a>
        @endisset
    </div>
    <div class="card-header bg-secondary text-white">
        <h3 class="text-center">
            Store Create
        </h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('vendor.store.save')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="current" @isset($current) value="{{$current->id}}" @endisset>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="">Store Name:</label>
                                <input type="text" name="name" @isset($current) value="{{$current->name}}" @endisset class="form-control" required="1">
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="">Address:</label>
                                    <input type="text" name="address" @isset($current) value="{{$current->address}}" @endisset class="form-control" required="1">
                                </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="">Contact No:</label>
                                    <input type="text" name="contact" @isset($current) value="{{$current->contact}}" @endisset class="form-control" required="1">
                                </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="">User Name:</label>
                                    <input type="text" name="user_name" @isset($current) value="{{$current->user_name}}" @endisset class="form-control" required="1">
                                </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="">Password:</label>
                                <input type="text" name="password" @isset($current) value="{{$current->password}}" @endisset class="form-control" required="1">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <label for="">Store Image:</label>
                            <div class="form-group">
                                <input type="file" name="store_image"  class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="">Longitude:</label>
                                <input type="text" name="longitude" @isset($current) value="{{$current->Longitude}}" @endisset class="form-control" required="1">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="">Latitude:</label>
                                <input type="text" name="latitude" @isset($current) value="{{$current->latitude}}" @endisset class="form-control" required="1">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="">&nbsp;</label><br>
                                <input type="submit" class="btn btn-success">
                            </div>
                        </div>
                        </div>

                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped table-border">
                    <thead>
                        <tr>
                            <th>Store Name</th>
                            <th>Image</th>
                            <th>Address</th>
                            <th>Contact No</th>
                            <th>User Name</th>
                            <th>Longitude</th>
                            <th>Latitude</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stores as $store)
                            <tr>
                                <td>{{$store->name}}</td>
                                <td><img src="{{Storage::disk('s3')->url(helperAwsLocation(7))}}{{$store->image}}" style="width: 100px; height: 100px;"/></td>
                                <td>{{$store->address}}</td>
                                <td>{{$store->contact}}</td>
                                <td>{{$store->user_name}}</td>
                                <td>{{$store->Longitude}}</td>
                                <td>{{$store->latitude}}</td>
                                <td>
                                    <?php
                                    if($store->status == '1')
                                        echo "<button class='btn btn-sm btn-light' style='color:green;'  >Active</button>";
                                    if($store->status == '2')
                                        echo "<button class='btn btn-sm btn-light' style='color:red;' >InActive</button>";
                                    ?>
                                </td>
                                </td>
                                <td><a href="{{route('vendor.store.edit',['id'=>$store->id])}}" class="btn btn-xs btn-primary">Edit</a>
                                @if ($store->status == 1)
                                    <a href="{{route('vendor.store.status',['id'=>$store->id])}}" class="btn btn-xs btn-danger">Deactive</a>
                                @else
                                   <a href="{{route('vendor.store.status',['id'=>$store->id])}}" class="btn btn-xs btn-success">Active</a>
                                @endif
                                    <a href="{{route('vendor.store.delete',['id'=>$store->id])}}" class="btn btn-xs btn-danger">Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
