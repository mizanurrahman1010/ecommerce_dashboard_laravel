@extends('layouts.owner')
@section('css')
<style media="screen">
    #hide-alert {
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
        <h5>Slider Upload</h5>

    </div>
    <div class="card-body">


        <form id="uform" class="row" action="" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group col-12 col-md-6">
              <h6 class="mb-3"> height:<span class="text-danger">600px</span> width:<span class="text-danger">1000px</span> File type:<span class="text-danger">JPG</span> Max:<span class="text-danger">70 KB</span></h6>
                <label class="mb-3 d-flex align-items-center text-primary font-weight-bold cursor-pointer" for="imgInp">
                    <i style="font-size:20px;" class='bx bx-duplicate px-2 py-1 text-white bg-primary'></i>
                    <h6 style="border:1px solid #007bff;width:100%;" class="mb-0 px-2 py-2">Browse File</h6>
                </label>

                <p class="text-danger font-weight-bold my-2" id="name-error"></p>


                <input name="name" type='file' id="imgInp" class="d-none" />
                <input type="submit" class="btn btn-success mt-3" name="" value="Upload">
            </div>
            <div class="col-12 col-md-6">
                <img src="" style="max-width:100%;max-height: 143px;" id="blah" src="#" alt="" />
            </div>
        </form>

    </div>
</div>


<div class="card">
    <div class="card-header">
        <h5>Slider List</h5>
    </div>
    <div class="card-body">
        <div id="allslider" class="row">

        </div>
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



    $('#uform').on('submit', function(event) {
        event.preventDefault();
        var myformData = new FormData(this);
        $.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: myformData,
            enctype: 'multipart/form-data',
            url: "/owner/slider/store",

            success: function(response) {
                alldata();
                $('#blah').attr('src', '');
                $("#sina-alert").addClass( "alert-success" ).text("Image Uploaded").show('slow');
                window.setTimeout(function() {
                    $("#sina-alert").hide("slow").removeClass( "alert-success" ).text("");
                }, 2000);
                  $('#name-error').text("");


            },
            error: function(error) {
              $('#name-error').text(error.responseJSON.errors.name);
            }
        });
    });



    function alldata() {

        $.ajax({
            type: "GET",
            url: "/owner/slider/get",
            dataType: "json",
            beforeSend: function() {
                $('#allslider').html("please wait...");
            },
            success: function(response) {

              if (response.list.length == 0) {
                  $('#allslider').html("<p colspan='3' class='alert alert-warning font-weight-bold'>sorry no data here</p>");
              } else {
                var data = "";
                $.each(response.list, function(key, value) {

                    data = data + "<div rowid='"+value.id+"' class='col-md-3 mb-2'>"
                    data = data + "<div style='position:relative;'>"
                    data = data + "<button style='position:absolute;top:8px;right:8px;' type='button' onclick='deleteData(" + value.id + ")' class='btn btn-danger'><i class='fadeIn animated bx bx-trash-alt'></i></button>"
                    data = data + "<img style='max-width:100%;' src='"+response.imgLoc+"" + value.name + "'>"
                    data = data + "</div>"
                    data = data + "</div>"
                });
                $('#allslider').html(data);
              }



            },
        });

    }


    function deleteData(id) {

      $.confirm({
          title: 'Are you sure?',
          content: 'This is Permanent Delete.',
          type: 'red',
          typeAnimated: true,
          buttons: {
              tryAgain: {
                  text: 'Delete Now',
                  btnClass: 'btn-red',
                  action: function(){
                    $.ajax({
                        type: "POST",
                        url: "/owner/slider/delete/" + id,
                        success: function(response) {

                          $("#sina-alert").addClass( "alert-danger" ).text("Data deleted").show('slow');
                          window.setTimeout(function() {
                              $("#sina-alert").hide("slow").removeClass( "alert-danger" ).text("");
                          }, 2000);

                           $("[rowid="+id+"]").hide('slide', function(){ $("[rowid="+id+"]").remove(); });
                        },

                    });
                  }
              },
              close: function () {
              }
          }
      });
    }





    alldata();




</script>
@endsection
