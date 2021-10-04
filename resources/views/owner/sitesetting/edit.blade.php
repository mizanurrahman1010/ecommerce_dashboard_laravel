@extends('layouts.owner')
@section('css')
  <style media="screen">
    #hide-alert{
      position: fixed;
      top: 70px;
      right: 1px;
      z-index: 99;
      width: 200px;
    }
  </style>
@endsection
@section('content')

  @if (session('success'))
    <div class="alert alert-success" id="hide-alert">
        {{ session('success') }}
    </div>
  @endif
  @if ($errors->any())
      <div class="alert alert-danger" id="hide-alert">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif


  <div class="card">
						<div class="card-header">
              <h5>Info setting</h5>

            </div>
						<div class="card-body">
              <form class="row" action="{{route('owner.sitesetting.update',[$setting->id])}}" method="post" enctype="multipart/form-data">
                      @csrf
                      @method('put')

                        <div class="form-group col-md-6">
                          <label>Site Name</label>
                          <input required value="{{$setting->name}}" name="name" type="text" class="form-control"  >
                        </div>
                        <div class="form-group col-md-6">
                          <label>Phone</label>
                          <input required value="{{$setting->phone}}" name="phone" type="text" class="form-control"  >
                        </div>
                        <div class="form-group col-md-12">
                          <label>address</label>
                          <input required value="{{$setting->address}}" name="address" type="text" class="form-control"  >
                        </div>
                        <div class="form-group col-md-6">
                          <label>email</label>
                          <input required value="{{$setting->email}}" name="email" type="text" class="form-control"  >
                        </div>
                        <div class="form-group col-md-6">
                          <label>shipping cost</label>
                          <input required value="{{$setting->shipping_cost}}" name="shipping_cost" type="text" class="form-control"  >
                        </div>


                        <div class="form-group col-md-6">
                          <label>facebook <span class="text-secondary">(optional)</span> </label>
                          <input value="{{$setting->facebook}}" name="facebook" type="text" class="form-control"  >
                        </div>
                        <div class="form-group col-md-6">
                          <label>twitter <span class="text-secondary">(optional)</span> </label>
                          <input value="{{$setting->twitter}}" name="twitter" type="text" class="form-control"  >
                        </div>
                        <div class="form-group col-md-6">
                          <label>linkedin <span class="text-secondary">(optional)</span> </label>
                          <input value="{{$setting->linkedin}}" name="linkedin" type="text" class="form-control"  >
                        </div>
                        <div class="form-group col-md-6">
                          <label>youtube <span class="text-secondary">(optional)</span> </label>
                          <input value="{{$setting->youtube}}" name="youtube" type="text" class="form-control"  >
                        </div>
                        <div class="form-group col-md-6">
                          <label>pinterest <span class="text-secondary">(optional)</span> </label>
                          <input value="{{$setting->pinterest}}" name="pinterest" type="text" class="form-control"  >
                        </div>






                      <div class="form-group col-12">
                      <input type="submit" class="btn btn-primary" name="" value="Update setting">

                      </div>
                    </form>
						</div>
					</div>

@endsection

@section('js')
  <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
  <script>
  window.setTimeout(function() {
      $("#hide-alert").hide("slow");
  }, 2000);
  </script>
@endsection
