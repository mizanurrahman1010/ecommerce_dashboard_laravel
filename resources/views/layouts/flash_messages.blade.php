@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block text-center mt-2">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('danger'))
    <div class="alert alert-danger alert-block text-center mt-2">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block text-center mt-2">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-block text-center mt-2">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Not Saved!!! Check The Form</strong>
    </div>
@endif
