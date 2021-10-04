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
              <h5>Logo</h5>
            </div>
						<div class="card-body">
              <div class="row mb-4">
                <h6>Maximum height: <span class="text-danger">120px</span> Maximum width: <span class="text-danger">200px</span> </h6>
              </div>
              <form class="row" action="{{route('owner.sitesetting.logoupdate',[$setting->id])}}" method="post" enctype="multipart/form-data">
                      @csrf
                      @method('put')

                        <div style="position:relative;" class="form-group ml-3">
                          <label  style="position:absolute;width: 100%;height: 100%;" class="text-primary font-weight-bold cursor-pointer" for="imgInp"><i style="font-size:20px;" class='bx bxs-edit px-2 py-1 text-white bg-primary'></i></label>
                          <input name="logo" type='file' id="imgInp" class="d-none" />
                          <img class="cursor-pointer"  src="{{asset('images')}}/aboutimg/{{$setting->logo}}" style="max-width:200px;" id="blah" src="#" alt="" />
                        </div>




                      <div class="form-group col-12">
                      <input type="submit" class="btn btn-primary" name="" value="Update Logo">

                      </div>
                    </form>
						</div>
					</div>

@endsection

@section('js')

  <script>
  function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#imgInp").change(function() {
  readURL(this);
});
  window.setTimeout(function() {
      $("#hide-alert").hide("slow");
  }, 2000);
  </script>
@endsection
