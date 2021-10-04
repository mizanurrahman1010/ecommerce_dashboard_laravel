@extends('layouts.owner')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>Campaign Details</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hovered">
                <thead>
                    <tr>
                        <th>Campaign Name</th>
                        <th>Store Name</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>CashBack</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cam_details as $cd)
                        <tr>
                            <td>{{$cd->get_campaign_name->name}}</td>
                            <td>{{$cd->get_store_name->name}}</td>
                            <td>{{$cd->get_product_name->name}}</td>
                            <td>{{$cd->price}}</td>
                            <td>{{$cd->cashback}}</td>
                            <td>{{$cd->discount}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
