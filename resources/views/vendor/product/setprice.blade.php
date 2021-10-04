@extends('layouts.vendor')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <a href="{{route('vendor.dashboard')}}" class="btn btn-primary px-5 mr-3">Back</a>
                <h5>Set Price For {{$product->name}}</h5>
            </div>
        </div>

        @error('product_id')<div class="alert alert-danger">{{ $message }}</div>@enderror

        <div class="card-body">
            <form action="{{route('product.set_price.store')}}" method="post">
                @csrf
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <div class="row">
                    <div class="form-group col">
                        <label>Select Store:</label>
                        <select name="store_id" id="" class="form-control">
                            @forelse ($stores as $store)
                                <option value="{{$store->id}}">{{$store->name}}</option>
                            @empty
                                <option value="0">No Store Found</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group col">
                        <label>Product Price:</label>
                        <input type="number" class="form-control" id="" name="price"  placeholder="Enter Product Price">
                    </div>

                    <div class="form-group col">
                        <label>Discount (%):</label>
                        <input type="number" class="form-control" id="" name="discount"  placeholder="Enter Discount Percentage (%)">
                    </div>

                    @if($product->size_group == 0 && $product->color_group == 0)
                        <div class="form-group col">
                            <label>Quantity:</label>
                            <input type="number" class="form-control" id="" name="quantity_without_cs"  placeholder="Enter Quantity">
                        </div>
                    @else
                        <div class="form-group col">
                            <label>Set Quantity Color And Size Wise:</label><br>
                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#cas_wise_quantity">Set Quantity</button>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="cas_wise_quantity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Set Quantity Color And Size Wise</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <tr>
                                            <th>Size</th>
                                            <th>Color</th>
                                            <th>Qty</th>
                                        </tr>
                                        @foreach ($sizes as $size)
                                            <tr>
                                                <td>
                                                    {{$size->name}}
                                                </td>
                                                <td>
                                                    @foreach ($colors as $color)
                                                    <input type="hidden" name="sizes[]" value="{{$size->id}}">
                                                    <input type="hidden" name="colors[]" value="{{$color->id}}">
                                                        <div class="d-flex justify-content-between mt-2">
                                                            <p class="d-inline-block">{{$color->name}}</p>
                                                            <input style="width: 70%;" type="text" name="quantity[]" class="form-control d-inline-block">
                                                        </div>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                {{-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                                </div> --}}
                            </div>
                            </div>
                        </div>

                    @endif

                    <div class="form-group col">
                        <label for="">&nbsp;</label><br>
                        <input type="submit" class="btn btn-success btn-sm btn-block" name="" value="Create Product">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('js')


    <script>
        $(document).ready(function(){
            $('.set_quantity').click(function(){

            });
        });
    </script>

@endsection
