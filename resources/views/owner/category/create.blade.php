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
          <a class="nav-item nav-link active" id="nav-category-tab" data-toggle="tab" href="#nav-category" onclick="alldata(1);" role="tab" aria-controls="nav-category" aria-selected="true">Department</a>
          <a class="nav-item nav-link" id="nav-subcategory-tab" data-toggle="tab" href="#nav-subcategory" onclick="alldata(2);" role="tab" aria-controls="nav-subcategory" aria-selected="false">Category</a>
          <a class="nav-item nav-link" id="nav-subsubcategory-tab" data-toggle="tab" href="#nav-subsubcategory" onclick="alldata(3);" role="tab" aria-controls="nav-subsubcategory" aria-selected="false">Sub Category</a>
          <a class="nav-item nav-link" id="nav-sub3category-tab" data-toggle="tab" href="#nav-sub3category" onclick="alldata(4);" role="tab" aria-controls="nav-sub3category" aria-selected="false">Sub SubCategory</a>
        </div>
    </nav>
      <div class="tab-content py-3 px-3" id="nav-tabContent">
        <div class="tab-pane fade show active" 
            id="nav-category" role="tabpanel" 
            aria-labelledby="nav-category-tab">
            <div class="row mt-4">
                <?php $data=['level_params' => 1];?>
                <div class="col-12">
                    <h5 class="border p-2 mb-0 bg-grey">Category</h5>
                    <div class="border p-2">
                        <form name="cform" id="cform" class="row mt-3 cform">
                            @csrf
                            @include("owner.category.formDepartment",$data)
                         </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-subcategory" role="tabpanel" aria-labelledby="nav-subcategory-tab">
            <div class="row mt-4">
                <?php 
                    $data=['level_params' => 2];
                ?>        
                <div class="col-12">
                    <h5 class="border p-2 mb-0 bg-grey">Sub Category</h5>
                    <div class="border p-2">
                        <form class="row mt-3 cform">
                            @csrf
                            @include("owner.category.formCategoryOthers",$data);
                         </form>
                    </div>
                </div>
            </div>
        </div>
         <?php $data=['level_params' => 3];?>
        <div class="tab-pane fade" id="nav-subsubcategory" role="tabpanel" aria-labelledby="nav-subsubcategory-tab">
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="border p-2 mb-0 bg-grey">Add sub Sub Category</h5>
                    <div class="border p-2">
                        <form  class="row mt-3 cform">
                            @csrf
                            @include("owner.category.formCategoryOthers",$data);
                         </form>
                    </div>
                </div>
            </div>
        </div>
        <?php $data=['level_params' => 4];?>
        <div class="tab-pane fade" id="nav-sub3category" role="tabpanel" aria-labelledby="nav-sub3category-tab">
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="border p-2 mb-0 bg-grey">Add Sub Sub Category</h5>
                    <div class="border p-2">
                        <form class="row mt-3 cform">
                            @csrf
                            @include("owner.category.formCategoryOthers",$data);
                         </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="col-12 mt-3">
        <h5 class="border p-2 mb-0 bg-grey">Manage Category</h5>
        <div class="border">
            <div class="table-responsive" id="">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th scope="col">Category Image</th>
                            <th scope="col">Category Name</th>
                            <th>H.Page Status</th>
                            <th>Sort Id</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="parentbody">
                    </tbody>  
                </table>
            </div>
        </div>
    </div>
</div>

<div class="edit-card-pop" id="edit-card" style="display: none;">
    <div  class="card">
        <div class="card-header d-flex flex-wrap justify-content-between">
            <h5 class="mb-0">Edit Category</h5>
            <button onclick="editback()" class="btn btn-danger p-0" 
            type="button" name="button"><i class='bx bx-x px-2'></i></button>
        </div>
        <div class="card-body">
            <form class="" name="eform" id="eform" >
                @csrf
                <div class="form-body">
                    <div class="form-group row">
                        <label class="col-12">Category name:</label>
                        <div class="col-12">
                            <input id="ename" name="name" type="text" class="form-control">
                            <div class="text-danger font-weight-bold py-2 text-white mt-0" id="ename-error"></div>
                            <input name="image" type="file" class="form-control" id="image">
                            <span id="eimage-error" class="form-text font-weight-bold text-danger"></span>
                        </div>
                        <input class="col-12" name="update_id" type="hidden" id="updateid" />
                    </div>
                    <div class="form-group row">
                        <label class="col-12">Status</label>
                        <div class="col-12">
                            <select class="form-control" name="edit_status">
                                <option class="edit_status_1" value="1">Active</option>
                                <option class="edit_status_2" value="2">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <p style="margin:0;padding:0">
                                Home Page Status
                            </p>
                            <select class="form-control" name="home_page_status">
                                <option class="home_page_status-1" value="1">Show</option>
                                <option class="home_page_status-2" value="2">Hide</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <p style="margin:0;padding:0">
                                Sort Id
                            </p>
                            <input class="form-control sort_id" name="sort_id"  />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <input  type="submit" id="update-button" class="btn btn-primary px-5" value="update">
                            {{--<button id="update-button" type="button" class="btn btn-primary px-4">Update</button> --}}
                        </div>
                    </div>
                </div>
            </form>
    
        </div>
    </div>
</div>
@endsection
@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
// functions for sub 3 category start

   
    // functions for sub category end
    // functions for parent category start
    $('.cform').on('submit', function(event) {
        event.preventDefault();
        var myformData = new FormData(this);
        $.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
             data: myformData,
            // data: { 'formdata' : myformData },
            enctype: 'multipart/form-data',
            url: "/owner/category/store",

            success: function(response) {

                //var response=JSON.parse(response);
                //console.log(response);
                //alert(response.info.level_id);    
                $("#sina-alert").addClass( "alert-success" ).text("added success").show('slow');
                window.setTimeout(function() {
                    $("#sina-alert").hide("slow").removeClass( "alert-success" ).text("");
                }, 2000);
                //alert("ok="+response.level_id);
                // $('#create-button').html("Create");
                $('#name').val("");
                $('#name-error').text("");
                alldata(response.info.level_id);

                // loadsubdropdown();
                $('.cform').trigger("reset");


            },
            error: function(error) {
                $('.name-error').text(error.responseJSON.errors.name);
                $('.image-error').text(error.responseJSON.errors.image);
                //$('#create-button').html("Create");
            }
        });
       
        // addData();
    });
    $('#eform').on('submit', function(event) {
        event.preventDefault();
        var myformData = new FormData(this);

        $.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
             data: myformData,
            // data: { 'formdata' : myformData },
            enctype: 'multipart/form-data',
            url: "/owner/category/update",

            success: function(response) {

                //var response=JSON.parse(response);
                //console.log(response);
                //alert(response.info.level_id);    
                $("#sina-alert").addClass( "alert-success" ).text("added success").show('slow');
                window.setTimeout(function() {
                    $("#sina-alert").hide("slow").removeClass( "alert-success" ).text("");
                }, 2000);
                //alert("ok="+response.level_id);
                // $('#create-button').html("Create");
                $('#ename').val("");
                $('#ename-error').text("");
                alldata(response.info.level_id);
                $('#eform').trigger("reset");

            },
            error: function(error) {
                $('#ename-error').text(error.responseJSON.errors.name);
                $('#eimage-error').text(error.responseJSON.errors.image);
            }
        });
       
        // addData();
    });
    function editback(){
      $("#edit-card").hide('slow');
    }
    alldata();
    function alldata(level_id=1) 
    {
        $(".parent_id").html("");
        $.ajax({
            type: "GET",
            url: "/owner/category/get/"+level_id,
            dataType: "json",
            beforeSend: function() {
                $('#parentbody').html("please wait...");
            },
            success: function(response) {
                var options="";
                $.each(response.categories, function(key, value) 
                {
                    options+="<option value='"+value.id+"'>"+value.name+"</option>";
               })
               $('.parent_id').html(options);
                var data = "";var sl=1;
                $.each(response.list, function(key, value) {
                    var status_msg="Show";
                    if(value.home_page_show_status == '2')
                        status_msg="Hide";
                    if(value.child.length == 0){
                        var db = "<button onclick='deleteData(" + value.id + ")' class='btn btn-danger'>Delete</button>";
                    }else{
                        var db = "";
                    }
                    data = data + "<tr parentrowid='"+value.id+"'>"
                    data = data + "<td>" + sl +"</td>"
                    data = data + "<td>" + "<img style='max-height:60px;' src='"+response.imgLocation+""+value.image+"'  /></td>"
                    data = data + "<td>" + value.name +"</td>"
                    data = data + "<td>" + status_msg +"</td>"
                    data = data + "<td>" + value.sort_id +"</td>"
                    data = data + "<td>" + value.created_at.slice(0, 10) + "</td>"
                    data = data + "<td><button onclick='editData(" + value.id + ")' class='btn btn-info mr-2'>Edit</button>" + db;
                    data = data + "</td>"
                    data = data + "</tr>"
                    sl++;
                })
                $('#parentbody').html(data);
            },
           

        });
    }
    function editData(id) {
        $.ajax({
            type: "GET",
            url: "/owner/category/edit/" + id,
            dataType: "json",

            success: function(response) {

              $("#edit-card").show('fast');
              $(".edit_status_"+response.status).prop("selected",true);
              $(".home_page_status-"+response.home_page_show_status).prop("selected",true);
              $('.sort_id').val(response.sort_id);

              $('#ename').val(response.name);
              $('#updateid').val(response.id);
            },

        });
    }
    function updateData() {

      const name = $('#ename').val();
      const id = $('#updateid').val();

      $.ajax({
          type: "POST",
          data: {
              name: name
          },
          url: "/owner/category/update/"+id,
          dataType: "json",
          beforeSend: function() {
              $('#update-button').html("please wait...");
          },

          success: function(response) {

            $("#sina-alert").addClass( "alert-success" ).text("update success").show('slow');
            window.setTimeout(function() {
                $("#sina-alert").hide("slow").removeClass( "alert-success" ).text("");
            }, 2000);

              $('#update-button').html("Update");
              $('#ename-error').text("");
              alldata();
              loadsubdropdown();
              suballdata();
              editback();
          },
          error: function(error) {
              $('#ename-error').text(error.responseJSON.errors.name);
              $('#update-button').html("Update");
          }
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
                  action: function()
                  {

                    $.ajax({
                        type: "POST",
                        data:{id:id},
                        url: "/owner/category/delete/",
                        success: function(response) 
                        {

                            //loadsubdropdown();
                            $("#sina-alert").addClass( "alert-danger" ).text("Data deleted").show('slow');
                            window.setTimeout(function() {
                                $("#sina-alert").hide("slow").removeClass( "alert-danger" ).text("");
                            }, 2000);
                           $("[parentrowid="+id+"]").hide('slide', function(){ $("[parentrowid="+id+"]").remove(); });


                        },
                        error: function(error){
                                alert("Something went wrong");
                                //location.reload();
                        }

                    });

                  }
              },
              close: function () {
              }
          }
      });
    }
    // functions for parent category end
</script>
@endsection
