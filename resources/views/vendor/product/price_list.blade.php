@extends('layouts.vendor')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>Product Price List</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hoverd table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Img</th>
                        <th>Product Name</th>
                        <th>Price Store Wise</th>
                    </tr>
                </thead>
                <tbody>
                    @php $key = ($product_prices->currentPage() - 1) * $product_prices->perPage() @endphp
                    @foreach ($product_prices as $pp)
                        <tr>
                            {{-- <td>{{$key+1}}</td> --}}
                            <td>{{$key = $key+1}}</td>
                            <td width="10%"><img style="max-width: 100%" src="{{asset('images')}}/productimg/{{$pp->image}}" alt=""></td>
                            <td>{{$pp->name}}</td>
                            <td>
                                <table class="table table-sm table-borderless table-hover">
                                        <tr>
                                            <th>Store Name</th>
                                            <th>Price</th>
                                            <th>Discount</th>
                                        </tr>
                                    @foreach ($pp->get_price_store_wise as $pps)
                                        <tr>
                                            <td>{{$pps->get_store_name->name}}</td>
                                            <td>{{$pps->price}}</td>
                                            <td>{{$pps->discount}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $product_prices->links() !!}
        </div>
    </div>
@endsection
