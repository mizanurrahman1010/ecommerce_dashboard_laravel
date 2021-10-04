@extends('layouts.owner')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style>
        .sina-nav .nav-link.active{
            background: #287a6a !important;
        }
        .full-height-card{
            min-height: calc( 100vh + 3px );
        }
        .sina-nav > .nav.nav-tabs{
            border-radius: 4px;
            border: none;
            color:#fff;
            background:#272e38;


        }
        .sina-nav > div a.nav-item.nav-link
        {
            border: none;
            padding: 18px 25px;
            color:#fff;
            background:#3b424d;

        }

        .sina-nav > div a.nav-item.nav-link.active:after
        {
            content: "";
            position: relative;
            bottom: -51px;
            left: -10%;
            border: 15px solid transparent;
            border-top-color: #287a6a ;
        }
        .tab-content{
            background: #fdfdfd;
            line-height: 25px;
            padding:30px 25px;
        }

        .sina-nav > div a.nav-item.nav-link:hover,
        .sina-nav > div a.nav-item.nav-link:focus
        {
            border: none;
            background: #6d6e20;
            color:#fff;

            transition:background 0.20s linear;
        }
        i.bx.bx-x.px-2 {
            line-height: 10px;
        }
        .edit-card-pop{
            position: fixed;
            top: 0px;
            z-index: 99;
            background: #0000009e;
            right: 0px;
            width: 100%;
            height:100%;

        }
        .edit-card-pop > .card {
            position: fixed;
            width: 300px;
            top: 50%;
            right: 1px;
            transform: translate(-0%, -50%);
        }


    </style>
@endsection
@section('content')

    <div class="card full-height-card">
        <nav class="sina-nav">
            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-category-tab" data-toggle="tab" href="#nav-category" onclick="alldata();" role="tab" aria-controls="nav-category" aria-selected="true">Basic Information</a>
                <a class="nav-item nav-link" id="nav-subcategory-tab" data-toggle="tab" href="#nav-subcategory" onclick="suballdata();" role="tab" aria-controls="nav-subcategory" aria-selected="false">Banking Information</a>
                <a class="nav-item nav-link" id="nav-subsubcategory-tab" data-toggle="tab" href="#nav-subsubcategory" onclick="subsuballdata();" role="tab" aria-controls="nav-subsubcategory" aria-selected="false">Document</a>
            </div>
        </nav>
        <div class="tab-content py-3 px-3" id="nav-tabContent">

            {{-- parent category start --}}
            <div class="tab-pane fade show active" id="nav-category" role="tabpanel" aria-labelledby="nav-category-tab">
                <div class="card">
                    <div class="card-header bg-default">
                        <h3 class="text-center">Vendor Basic Information Add</h3>
                    </div>
                    <div class="card-body">
                        <form name="vendorCreateForm" action="{{route('owner.vendor_create_submit')}}" method="POST"
                              enctype="multipart/form-data" id="vendorCreateForm" class="">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger w-100">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Name:</label>
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Vendor name" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Email:</label>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Email" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Phone:</label>
                                    <div class="form-group">
                                        <input type="text" name="phone" class="form-control" placeholder="Phone No." >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Present Address:</label>
                                    <div class="form-group">
                                        <input type="text" name="present_address" class="form-control"
                                               placeholder="Present Address" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Permanent Address:</label>
                                    <div class="form-group">
                                        <input type="text" name="permanent_address" class="form-control"
                                               placeholder="Permanent Address" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Vendor Image</label>
                                    <div class="form-group">
                                        <input type="file" name="user_image" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">NID Number:</label>
                                    <div class="form-group">
                                        <input type="text" name="nid" class="form-control" placeholder="NID" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">NID (Front Image)</label>
                                    <div class="form-group">
                                        <input type="file" name="nid_img_front" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">NID (Back Image)</label>
                                    <div class="form-group">
                                        <input type="file" name="nid_img_back" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Password</label>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password" >
                                        <span class="text-danger">@error("password"){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Confirm Password</label>
                                    <div class="form-group">
                                        <input type="password" name="confirm_password" class="form-control"
                                               placeholder="Confirm Password" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="exampleInputName2">type of Business:</label>
                                    <select class="browser-default custom-select" id="BusinessTypeId" name="BusinessTypeId">
                                        <option value="0">Select</option>
                                        @foreach($data3 as $val)
                                            <option value={{$val->id}}>{{$val->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="exampleInputName2">Nature of Business:</label>
                                    <select class="browser-default custom-select" id="BNatureId" name="BNatureId">
                                        <option value="0">Select</option>
                                        @foreach($data4 as $val)
                                            <option value={{$val->id}}>{{$val->name}}</option>
                                        @endforeach

                                    </select>

                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="exampleInputName2">Product Type:</label><br>
                                    @foreach($data5 as $val)
                                        <input type="checkbox" name="product_type[]" value="{{$val->id}}" />   {{$val->name}}
                                    @endforeach
                                    {{--                                    <select class="browser-default custom-select" id="product_type" name="product_type">--}}
                                    {{--                                        <option value="0">Select</option>--}}
                                    {{--                                        @foreach($data5 as $val)--}}
                                    {{--                                            <option value={{$val->id}}>{{$val->name}}</option>--}}
                                    {{--                                        @endforeach--}}

                                    {{--                                    </select>--}}

                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Vendor Manual Code:</label>
                                    <div class="form-group">
                                        <input type="text" name="manual_code" class="form-control" placeholder="enter manual code" >
                                    </div>
                                </div>
{{--                                <div class="col-md-12 text-center">--}}
{{--                                    <input type="submit" id="create-button" class="btn btn-primary px-5" value="Create">--}}
{{--                                    --}}{{-- <button id="create-button" type="button" onclick="addData()" class="btn btn-primary px-5">Create </button> --}}
{{--                                </div>--}}
                            </div>
{{--                        </form>--}}
                    </div>
                </div>
            </div>
            {{-- parent category end --}}

            {{-- sub category start --}}
            <div class="tab-pane fade" id="nav-subcategory" role="tabpanel" aria-labelledby="nav-subcategory-tab">
                <div class="card">
                    <div class="card-header bg-default">
                        <h3 class="text-center">Vendor Banking Information</h3>
                    </div>
                    <div class="card-body">
{{--                        <form name="vendorCreateForm" action="{{route('owner.vendor_create_submit')}}" method="POST"--}}
{{--                              enctype="multipart/form-data" id="vendorCreateForm" class="">--}}
{{--                            @csrf--}}
{{--                            @if ($errors->any())--}}
{{--                                <div class="alert alert-danger w-100">--}}
{{--                                    <ul>--}}
{{--                                        @foreach ($errors->all() as $error)--}}
{{--                                            <li class="">{{ $error }}</li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            @endif--}}
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Account Name:</label>
                                    <div class="form-group">
                                        <input type="text" name="account_name" class="form-control" placeholder="Account Name">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Account Number:</label>
                                    <div class="form-group">
                                        <input type="text" name="account_number" class="form-control" placeholder="Account number">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Routing Number:</label>
                                    <div class="form-group">
                                        <input type="text" name="routing_number" class="form-control" placeholder="Routing Number">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Bank Name:</label>
                                    <div class="form-group">
                                        <input type="text" name="bank_name" class="form-control" placeholder="Bank Name">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Branch Name:</label>
                                    <div class="form-group">
                                        <input type="text" name="branch_name" class="form-control" placeholder="Branch Name" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Branch Code:</label>
                                    <div class="form-group">
                                        <input type="text" name="branch_code" class="form-control" placeholder="Branch Code" >
                                    </div>
                                </div>

{{--                                <div class="col-md-12 text-center">--}}
{{--                                    <input type="submit" id="create-button" class="btn btn-primary px-5" value="Create">--}}
{{--                                    --}}{{-- <button id="create-button" type="button" onclick="addData()" class="btn btn-primary px-5">Create </button> --}}
{{--                                </div>--}}
                            </div>
{{--                        </form>--}}
                    </div>
                </div>
            </div>
            {{-- sub category end --}}

            {{-- sub sub category start --}}
            <div class="tab-pane fade" id="nav-subsubcategory" role="tabpanel" aria-labelledby="nav-subsubcategory-tab">
                <div class="card">
                    <div class="card-header bg-default">
                        <h3 class="text-center">Vendor Document Add</h3>
                    </div>
                    <div class="card-body">
{{--                        <form name="vendorCreateForm" action="{{route('owner.vendor_create_submit')}}" method="POST"--}}
{{--                              enctype="multipart/form-data" id="vendorCreateForm" class="">--}}
{{--                            @csrf--}}
{{--                            @if ($errors->any())--}}
{{--                                <div class="alert alert-danger w-100">--}}
{{--                                    <ul>--}}
{{--                                        @foreach ($errors->all() as $error)--}}
{{--                                            <li class="">{{ $error }}</li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            @endif--}}
                            <div class="row">

                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Trade License No:</label>
                                    <div class="form-group">
                                        <input type="text" name="trade_l_no" class="form-control" placeholder="Trace License No" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Trade License File:</label>
                                    <div class="form-group">
                                        <input type="file" name="trade_l_file" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Vat Certification No:</label>
                                    <div class="form-group">
                                        <input type="text" name="Vat_c_no" class="form-control" placeholder="Trace License No" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Vat Certification File:</label>
                                    <div class="form-group">
                                        <input type="file" name="vat_c_file" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">TIN Certification No:</label>
                                    <div class="form-group">
                                        <input type="text" name="tin_c_no" class="form-control" placeholder="TIN Certification No" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">TIN Certification File:</label>
                                    <div class="form-group">
                                        <input type="file" name="tin_c_file" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">BSTI Certification No:</label>
                                    <div class="form-group">
                                        <input type="text" name="bsti_c_no" class="form-control" placeholder="BSTI Certification No" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">BSTI Certification File:</label>
                                    <div class="form-group">
                                        <input type="file" name="bsti_c_file" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Licence No(Country where registerd)</label>
                                    <div class="form-group">
                                        <input type="text" name="licence_no" class="form-control" placeholder="Licence Bo" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">TIN/tax ID:</label>
                                    <div class="form-group">
                                        <input type="text" name="tin_tax_id" class="form-control" placeholder="TIN/Tax id" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Vat No:</label>
                                    <div class="form-group">
                                        <input type="text" name="vat_no" class="form-control" placeholder="Vat No" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <label for="">Incorporation No:</label>
                                    <div class="form-group">
                                        <input type="text" name="incorporation_no" class="form-control" placeholder="Incorporation No" >
                                    </div>
                                </div>


                                <div class="col-md-12 text-center">
                                    <input type="submit" id="create-button" class="btn btn-primary px-5" value="Create">
                                    {{-- <button id="create-button" type="button" onclick="addData()" class="btn btn-primary px-5">Create </button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- sub sub category end --}}

        </div>
    </div>




{{--    <div class="card">--}}
{{--        <div class="card-header bg-default">--}}
{{--            <h3 class="text-center">Vendor Create</h3>--}}
{{--        </div>--}}
{{--        <div class="card-body">--}}
{{--            <form name="vendorCreateForm" action="{{route('owner.vendor_create_submit')}}" method="POST"--}}
{{--                  enctype="multipart/form-data" id="vendorCreateForm" class="">--}}
{{--                @csrf--}}
{{--                @if ($errors->any())--}}
{{--                    <div class="alert alert-danger w-100">--}}
{{--                        <ul>--}}
{{--                            @foreach ($errors->all() as $error)--}}
{{--                                <li class="">{{ $error }}</li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-3 col-sm-6 col-12">--}}
{{--                        <label for="">Name</label>--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="text" name="name" class="form-control" placeholder="Vendor name">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3 col-sm-6 col-12">--}}
{{--                        <label for="">Email</label>--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="email" name="email" class="form-control" placeholder="Email">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3 col-sm-6 col-12">--}}
{{--                        <label for="">Phone</label>--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="text" name="phone" class="form-control" placeholder="Phone No.">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3 col-sm-6 col-12">--}}
{{--                        <label for="">NID</label>--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="text" name="nid" class="form-control" placeholder="NID">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3 col-sm-6 col-12">--}}
{{--                        <label for="">Present Address</label>--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="text" name="present_address" class="form-control"--}}
{{--                                   placeholder="Present Address">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3 col-sm-6 col-12">--}}
{{--                        <label for="">Permanent Address</label>--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="text" name="permanent_address" class="form-control"--}}
{{--                                   placeholder="Permanent Address">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3 col-sm-6 col-12">--}}
{{--                        <label for="">User Image</label>--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="file" name="user_image" class="form-control">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3 col-sm-6 col-12">--}}
{{--                        <label for="">NID Image(Front)</label>--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="file" name="nid_img_front" class="form-control">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3 col-sm-6 col-12">--}}
{{--                        <label for="">NID Image(Back)</label>--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="file" name="nid_img_back" class="form-control">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3 col-sm-6 col-12">--}}
{{--                        <label for="">Trade License No</label>--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="text" name="trade_license_no" class="form-control"--}}
{{--                                   placeholder="Trade license no.">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3 col-sm-6 col-12">--}}
{{--                        <label for="">Trade License Img</label>--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="file" name="trade_license_img" class="form-control">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3 col-sm-6 col-12">--}}
{{--                        <label for="">Password</label>--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="password" name="password" class="form-control" placeholder="Password">--}}
{{--                            <span class="text-danger">@error("password"){{$message}}@enderror</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3 col-sm-6 col-12">--}}
{{--                        <label for="">Confirm Password</label>--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="password" name="confirm_password" class="form-control"--}}
{{--                                   placeholder="Confirm Password">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-12 text-center">--}}
{{--                        <input type="submit" id="create-button" class="btn btn-primary px-5" value="Create">--}}
{{--                        --}}{{-- <button id="create-button" type="button" onclick="addData()" class="btn btn-primary px-5">Create </button> --}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

