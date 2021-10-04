@extends('layouts.owner')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Store List</h3>
    </div>
    <div class="card-body">
        <form action="{{route('owner.store.list')}}" method="get">
            <div class="row mb-5">
                <div class="col-3">
                    <select name="vendor" class="form-control">
                        <option value="">All</option>
                        @foreach ($vendors as $vendor)
                            <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-1">
                    <button type="submit" class="btn btn-info">Search</button>
                </div>
            </div>
        </form>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Store Name</td>
                    <td>Vendors</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($stores as $key=>$store)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$store->name}}</td>
                        <td>{{$store->get_vendor_info->name}}</td>
                        <td>
                            @if($store->type == 1)
                                <a href="{{route('owner.store.make_or_remove_for_all',['id'=>$store->id])}}" class="btn btn-xs btn-info">Make Open For All</a>
                            @else
                                <a href="{{route('owner.store.make_or_remove_for_all',['id'=>$store->id])}}" class="btn btn-xs btn-danger">Remove Open For All</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
