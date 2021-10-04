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
          <a class="nav-item nav-link active" id="nav-category-tab" data-toggle="tab" href="#nav-category" onclick="alldata();" role="tab" aria-controls="nav-category" aria-selected="true">Category</a>
          <a class="nav-item nav-link" id="nav-subcategory-tab" data-toggle="tab" href="#nav-subcategory" onclick="suballdata();" role="tab" aria-controls="nav-subcategory" aria-selected="false">SubCategory</a>
          <a class="nav-item nav-link" id="nav-subsubcategory-tab" data-toggle="tab" href="#nav-subsubcategory" onclick="subsuballdata();" role="tab" aria-controls="nav-subsubcategory" aria-selected="false">SubSubCategory</a>
        </div>
    </nav>
      <div class="tab-content py-3 px-3" id="nav-tabContent">

        {{-- parent category start --}}
        <div class="tab-pane fade show active" id="nav-category" role="tabpanel" aria-labelledby="nav-category-tab">
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="border p-2 mb-0 bg-grey">Add Category</h5>
                    <div class="border p-2">
                        <form id="cform" class="row mt-3">
                            <div class="col-md-2">
                                <h6>Category Name:</h6>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="name"  placeholder="Enter category name">
                                <span id="name-error" class="form-text font-weight-bold text-danger"></span>
                            </div>
                            <div class="col-md-3">
                                <button id="create-button" type="button" onclick="addData()" class="btn btn-primary px-5">Create </button>
                            </div>
                         </form>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <h5 class="border p-2 mb-0 bg-grey">Manage Category</h5>
                    <div class="border">
                        <div class="table-responsive" id="">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Category Name</th>
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
        </div>
         {{-- parent category end --}}

          {{-- sub category start --}}
        <div class="tab-pane fade" id="nav-subcategory" role="tabpanel" aria-labelledby="nav-subcategory-tab">
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="border p-2 mb-0 bg-grey">Add Sub Category</h5>
                    <div class="border p-2">
                        <form id="subcform" class="row mt-3">
                            <div class="col-md-2 mt-3">
                                <h6>Parent id:</h6>
                            </div>
                            <div class="col-md-10 mt-3">
                                <select id="parent_id" name="parent_id" class="js-states form-control">
                                    <option value="">select parent</option>
                                    @foreach ($parent as $p)
                                        <option value="{{$p->id}}">{{$p->name}}</option>
                                    @endforeach
                                </select>
                                <span id="parent-error" class="form-text font-weight-bold text-danger"></span>
                            </div>
                            <div class="col-md-2 mt-3">
                                <h6>Sub Category Name:</h6>
                            </div>
                            <div class="col-md-10 mt-3">
                                <input type="text" class="form-control" id="subname"  placeholder="Enter sub category name">
                                <span id="subname-error" class="form-text font-weight-bold text-danger"></span>
                            </div>
                           
                            <div class="col-md-2 mt-3">
                                
                            </div>
                            <div class="col-md-10 mt-3">
                                <button id="subcreate-button" type="button" onclick="subaddData()" class="btn btn-primary px-5">Create </button>
                            </div>
                         </form>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <h5 class="border p-2 mb-0 bg-grey">Manage Category</h5>
                    <div class="border">
                        <div class="table-responsive" id="">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">Parent</th>
                                        <th scope="col">Created at</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="subbody">
                                </tbody>  
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- sub category end --}}

         {{-- sub sub category start --}}
        <div class="tab-pane fade" id="nav-subsubcategory" role="tabpanel" aria-labelledby="nav-subsubcategory-tab">
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="border p-2 mb-0 bg-grey">Add sub Sub Category</h5>
                    <div class="border p-2">
                        <form id="subsubcform" class="row mt-3">
                            <div class="col-md-2 mt-3">
                                <h6>Sub Parent id:</h6>
                            </div>
                            <div class="col-md-10 mt-3">
                                <select id="subparent_id" name="parent_id" class="js-states form-control">
                                    <option value="">select sub parent</option>
                                    @foreach ($subparent as $sp)
                                        <option value="{{$sp->id}}">{{$sp->name}}</option>
                                    @endforeach
                                </select>
                                <span id="subparent-error" class="form-text font-weight-bold text-danger"></span>
                            </div>
                            <div class="col-md-2 mt-3">
                                <h6>Sub sub Category Name:</h6>
                            </div>
                            <div class="col-md-10 mt-3">
                                <input type="text" class="form-control" id="subsubname"  placeholder="Enter sub sub category name">
                                <span id="subsubname-error" class="form-text font-weight-bold text-danger"></span>
                            </div>
                           
                            <div class="col-md-2 mt-3">
                                
                            </div>
                            <div class="col-md-10 mt-3">
                                <button id="subsubcreate-button" type="button" onclick="subsubaddData()" class="btn btn-primary px-5">Create </button>
                            </div>
                         </form>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <h5 class="border p-2 mb-0 bg-grey">Manage Category</h5>
                    <div class="border">
                        <div class="table-responsive" id="">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">Parent</th>
                                        <th scope="col">Created at</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="subsubbody">
                                </tbody>  
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- sub sub category end --}}
      
      </div>
</div>

<div class="edit-card-pop" id="edit-card" style="display: none;">
    <div  class="card">
        <div class="card-header d-flex flex-wrap justify-content-between">
            <h5 class="mb-0">Edit Category</h5>
            <button onclick="editback()" class="btn btn-danger p-0" type="button" name="button"><i class='bx bx-x px-2'></i></button>
        </div>
    
        <div class="card-body">
            <form class="" action="" id="eform" method="post">
                @csrf
                <div class="form-body">
                    <div class="form-group row">
                        <label class="col-12">Category name:</label>
                        <div class="col-12">
                            <input id="ename" type="text" class="form-control">
                            <div class="text-danger font-weight-bold py-2 text-white mt-0" id="ename-error"></div>
                        </div>
                        <input class="col-12" type="hidden" id="updateid" name="" value="">
                    </div>
    
                    <div class="form-group row">
                        
                        <div class="col-12">
                            <button id="update-button" type="button" onclick="updateData()" class="btn btn-primary px-4">Update</button>
                        </div>
                    </div>
                </div>
            </form>
    
        </div>
    </div>
</div>

<div class="edit-card-pop" id="subedit-card" style="display: none;">
    <div  class="card">
        <div class="card-header d-flex flex-wrap justify-content-between">
            <h5 class="mb-0">Edit Sub Category</h5>
            <button onclick="subeditback()" class="btn btn-danger p-0" type="button" name="button"><i class='bx bx-x px-2'></i></button>
        </div>
    
        <div class="card-body">
            <form class="" action="" id="subeform" method="post">
                @csrf
                <div class="form-body">
                    <div class="form-group row">
                        <label class="col-12">Parent id:</label>
                        <div class="col-12">
                            <select id="eparent_id" name="parent_id" class="js-states form-control">
                                <option value="">select parent</option>
                                    @foreach ($parent as $p)
                                        <option value="{{$p->id}}">{{$p->name}}</option>
                                    @endforeach
                            </select>
                            <span id="eparent-error" class="form-text font-weight-bold text-danger"></span>
                        </div>
                        <label class="col-12">Sub Category name:</label>
                        <div class="col-12">
                            <input id="subename" type="text" class="form-control">
                            <div class="text-danger font-weight-bold py-2 text-white mt-0" id="esubname-error"></div>
                        </div>
                       
                        <input class="col-12" type="hidden" id="subupdateid" name="" value="">
                    </div>
    
                    <div class="form-group row">
                        <div class="col-12">
                            <button id="subupdate-button" type="button" onclick="subupdateData()" class="btn btn-primary px-4">Update</button>
                        </div>
                    </div>
                </div>
            </form>
    
        </div>
    </div>
</div>

<div class="edit-card-pop" id="subsubedit-card" style="display: none;">
    <div  class="card">
        <div class="card-header d-flex flex-wrap justify-content-between">
            <h5 class="mb-0">Edit Sub sub Category</h5>
            <button onclick="subsubeditback()" class="btn btn-danger p-0" type="button" name="button"><i class='bx bx-x px-2'></i></button>
        </div>
    
        <div class="card-body">
            <form class="" action="" id="subsubeform" method="post">
                @csrf
                <div class="form-body">
                    <div class="form-group row">
                        <label class="col-12">Parent id:</label>
                        <div class="col-12">
                            <select id="subsubeparent_id" name="parent_id" class="js-states form-control">
                                <option value="">select parent</option>
                                    @foreach ($subparent as $sp)
                                        <option value="{{$sp->id}}">{{$sp->name}}</option>
                                    @endforeach
                            </select>
                            <span id="subsubeparent-error" class="form-text font-weight-bold text-danger"></span>
                        </div>
                        <label class="col-12">Sub sub Category name:</label>
                        <div class="col-12">
                            <input id="subsubename" type="text" class="form-control">
                            <div class="text-danger font-weight-bold py-2 text-white mt-0" id="esubsubname-error"></div>
                        </div>
                       
                        <input class="col-12" type="hidden" id="subsubupdateid" name="" value="">
                    </div>
    
                    <div class="form-group row">
                        <div class="col-12">
                            <button id="subsubupdate-button" type="button" onclick="subsubupdateData()" class="btn btn-primary px-4">Update</button>
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


        // functions for sub sub category start
        $('#subsubcform').on('submit', function(event) {
        event.preventDefault();
        subsubaddData();
    });
    $('#subsubeform').on('submit', function(event) {
        event.preventDefault();
        subsubupdateData();
    });
 
    function subsubeditback(){
      $("#subsubedit-card").hide('slow');
    }
    
    subsuballdata();
    function subsuballdata() {
       
        $.ajax({
            type: "GET",
            url: "/owner/subsubcategory/get",
            dataType: "json",
            beforeSend: function() {
                $('#subsubbody').html("please wait...");
            },
            success: function(response) {
               
                var data = "";
                $.each(response, function(key, value) {
                    data = data + "<tr subsubrowid='"+value.id+"'>"
                    data = data + "<td>" + value.name + "</td>"
                    data = data + "<td>" + value.parent.name + "</td>"
                    data = data + "<td>" + value.created_at.slice(0, 10) + "</td>"
                    data = data + "<td><button onclick='subsubeditData(" + value.id + ")' class='btn btn-info mr-2'>Edit</button><button onclick='subsubdeleteData(" + value.id + ")' class='btn btn-danger'>Delete</button></td>"
                    data = data + "</tr>"
                })
                $('#subsubbody').html(data);

            },
        });
    }

    function subsubaddData() {
        const name = $('#subsubname').val();
        const parent_id = $('#subparent_id').val();
        
      
        $.ajax({
            type: "POST",
            data: {
                name: name,
                parent_id: parent_id
            },
            url: "/owner/subsubcategory/store",
            dataType: "json",
            beforeSend: function() {
                $('#subsubcreate-button').html("please wait...");
            },
            success: function(response) {
                $("#sina-alert").addClass( "alert-success" ).text("added success").show('slow');
                window.setTimeout(function() {
                    $("#sina-alert").hide("slow").removeClass( "alert-success" ).text("");
                }, 2000);

                $('#subsubcreate-button').html("Create");
                $('#subsubname').val("");
                $('#subparent_id').val("");
                $('#subsubname-error').text("");
                $('#subparent-error').text("");
                subsuballdata();
            },
            error: function(error) {
                $('#subsubname-error').text(error.responseJSON.errors.name);
                $('#subparent-error').text(error.responseJSON.errors.parent_id);
                $('#subsubcreate-button').html("Create");
            }
        });
    }

    function subsubeditData(id) {
        $.ajax({
            type: "GET",
            url: "/owner/subsubcategory/edit/" + id,
            dataType: "json",

            success: function(response) {
              $("#subsubedit-card").show('fast');
                
              $('#subsubename').val(response.name);
              $('#subsubeparent_id').val(response.parent_id);
              $('#subsubupdateid').val(response.id);
            },

        });
    }
    function subsubupdateData() {
      const name = $('#subsubename').val();
      const id = $('#subsubupdateid').val();
      const parent_id = $('#subsubeparent_id').val();
    
    // alert(parent_id);
        

      $.ajax({
          type: "POST",
          data: {
              name: name,
              id: id,
              parent_id: parent_id
          },
          url: "/owner/subsubcategory/update/" + id,
          dataType: "json",
          beforeSend: function() {
              $('#subsubupdate-button').html("please wait...");
          },

          success: function(response) {

            $("#sina-alert").addClass( "alert-success" ).text("update success").show('slow');
            window.setTimeout(function() {
                $("#sina-alert").hide("slow").removeClass( "alert-success" ).text("");
            }, 2000);

              $('#subsubupdate-button').html("Update");
              $('#subsubename-error').text("");
              alldata();
              subsubeditback();
              subsuballdata();
              suballdata();
          },
          error: function(error) {
            $('#esubsubname-error').text(error.responseJSON.errors.name);
                $('#subsubeparent-error').text(error.responseJSON.errors.parent_id);
                $('#subsubupdate-button').html("Create");
          }
      });
    }
    function subsubdeleteData(id) {

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
                        url: "/owner/category/delete/" + id,
                        success: function(response) {

                          $("#sina-alert").addClass( "alert-danger" ).text("Data deleted").show('slow');
                          window.setTimeout(function() {
                              $("#sina-alert").hide("slow").removeClass( "alert-danger" ).text("");
                          }, 2000);

                           $("[subsubrowid="+id+"]").hide('slide', function(){ $("[subsubrowid="+id+"]").remove(); });
                        },

                    });
                  }
              },
              close: function () {
              }
          }
      });
    }
    // functions for sub sub category end
    
    
    // functions for sub category start
    $('#subcform').on('submit', function(event) {
        event.preventDefault();
        subaddData();
    });
    $('#subeform').on('submit', function(event) {
        event.preventDefault();
        subupdateData();
    });
 
    function subeditback(){
      $("#subedit-card").hide('slow');
    }
    
    suballdata();
    function suballdata() {
        $.ajax({
            type: "GET",
            url: "/owner/subcategory/get",
            dataType: "json",
            beforeSend: function() {
                $('#subbody').html("please wait...");
            },
            success: function(response) {
              
                var data = "";
                $.each(response, function(key, value) {

                    if(value.child.length == 0){
                        var db = "<button onclick='subdeleteData(" + value.id + ")' class='btn btn-danger'>Delete</button>";
                    }else{
                        var db = "";
                    }

                    data = data + "<tr subrowid='"+value.id+"'>"
                    data = data + "<td>" + value.name + "</td>"
                    data = data + "<td>" + value.parent.name + "</td>"
                    data = data + "<td>" + value.created_at.slice(0, 10) + "</td>"
                    data = data + "<td><button onclick='subeditData(" + value.id + ")' class='btn btn-info mr-2'>Edit</button>"+ db +"</td>"
                    data = data + "</tr>"
                })
                $('#subbody').html(data);

            },
        });
    }

    function subaddData() {
        const name = $('#subname').val();
        const parent_id = $('#parent_id').val();
        // alert(parent_id);
      
        $.ajax({
            type: "POST",
            data: {
                name: name,
                parent_id: parent_id
            },
            url: "/owner/subcategory/store",
            dataType: "json",
            beforeSend: function() {
                $('#subcreate-button').html("please wait...");
            },
            success: function(response) {
                $("#sina-alert").addClass( "alert-success" ).text("added success").show('slow');
                window.setTimeout(function() {
                    $("#sina-alert").hide("slow").removeClass( "alert-success" ).text("");
                }, 2000);

                $('#subcreate-button').html("Create");
                $('#subname').val("");
                $('#parent_id').val("");
                $('#subname-error').text("");
                $('#parent-error').text("");
                suballdata();
            },
            error: function(error) {
                $('#subname-error').text(error.responseJSON.errors.name);
                $('#parent-error').text(error.responseJSON.errors.parent_id);
                $('#subcreate-button').html("Create");
            }
        });
    }

    function subeditData(id) {
        $.ajax({
            type: "GET",
            url: "/owner/subcategory/edit/" + id,
            dataType: "json",

            success: function(response) {
              $("#subedit-card").show('fast');
                
              $('#subename').val(response.name);
              $('#eparent_id').val(response.parent_id);
              $('#subupdateid').val(response.id);
            },

        });
    }
    function subupdateData() {
      const name = $('#subename').val();
      const id = $('#subupdateid').val();
      const parent_id = $('#eparent_id').val();
    

      $.ajax({
          type: "POST",
          data: {
              name: name,
              id: id,
              parent_id: parent_id
          },
          url: "/owner/subcategory/update/" + id,
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
              subeditback();
              suballdata();
              loadsubsubdropdown();
          },
          error: function(error) {
            $('#esubname-error').text(error.responseJSON.errors.name);
                $('#eparent-error').text(error.responseJSON.errors.parent_id);
                $('#subupdate-button').html("Create");
          }
      });
    }
    function subdeleteData(id) {

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
                        url: "/owner/category/delete/" + id,
                        success: function(response) {

                          $("#sina-alert").addClass( "alert-danger" ).text("Data deleted").show('slow');
                          window.setTimeout(function() {
                              $("#sina-alert").hide("slow").removeClass( "alert-danger" ).text("");
                          }, 2000);

                           $("[subrowid="+id+"]").hide('slide', function(){ $("[subrowid="+id+"]").remove(); });
                        },

                    });
                  }
              },
              close: function () {
              }
          }
      });
    }
    // functions for sub category end


    // functions for parent category start
    $('#cform').on('submit', function(event) {
        event.preventDefault();
        addData();
    });
    $('#eform').on('submit', function(event) {
        event.preventDefault();
        updateData();
    });
    function editback(){
      $("#edit-card").hide('slow');
    }
    
    alldata();
    
    function alldata() {
        $.ajax({
            type: "GET",
            url: "/owner/category/get",
            dataType: "json",
            beforeSend: function() {
                $('#parentbody').html("please wait...");
            },
            success: function(response) {
                
                var data = "";
                $.each(response, function(key, value) {
                   
                    if(value.child.length == 0){
                        var db = "<button onclick='deleteData(" + value.id + ")' class='btn btn-danger'>Delete</button>";
                    }else{
                        var db = "";
                    }
                    
                    
                    data = data + "<tr parentrowid='"+value.id+"'>"
                    data = data + "<td>" + value.name +"</td>"
                    data = data + "<td>" + value.created_at.slice(0, 10) + "</td>"
                    data = data + "<td><button onclick='editData(" + value.id + ")' class='btn btn-info mr-2'>Edit</button>" + db;
                    data = data + "</td>"
                    data = data + "</tr>"
                })
                $('#parentbody').html(data);
            },
           

        });
    }

    function  loadsubdropdown() {
        $.ajax({
            type: "GET",
            url: "/owner/category/get",
            dataType: "json",
           
            success: function(response) {
                var data = "<option value=''>select parent</option>";
                $.each(response, function(key, value) {
                    data = data + "<option value='"+value.id+"'>"+value.name+"</option>"
                })
                $('#parent_id').html(data);
                $('#eparent_id').html(data);
            },
        });
    }
    function  loadsubsubdropdown() {
        $.ajax({
            type: "GET",
            url: "/owner/subcategory/get",
            dataType: "json",
           
            success: function(response) {
                var data = "<option value=''>select parent</option>";
                $.each(response, function(key, value) {
                    data = data + "<option value='"+value.id+"'>"+value.name+"</option>"
                })
                $('#subparent_id').html(data);
                // $('#subeparent_id').html(data);
            },
        });
    }

    function addData() {
        const name = $('#name').val();
        $.ajax({
            type: "POST",
            data: {
                name: name
            },
            url: "/owner/category/store",
            dataType: "json",
            beforeSend: function() {
                $('#create-button').html("please wait...");
            },
            success: function(response) {
                $("#sina-alert").addClass( "alert-success" ).text("added success").show('slow');
                window.setTimeout(function() {
                    $("#sina-alert").hide("slow").removeClass( "alert-success" ).text("");
                }, 2000);

                $('#create-button').html("Create");
                $('#name').val("");
                $('#name-error').text("");
                alldata();
                loadsubdropdown();
            },
            error: function(error) {
                $('#name-error').text(error.responseJSON.errors.name);
                $('#create-button').html("Create");
            }
        });
    }

    function editData(id) {
        $.ajax({
            type: "GET",
            url: "/owner/category/edit/" + id,
            dataType: "json",

            success: function(response) {
              $("#edit-card").show('fast');
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
                  action: function(){
                    $.ajax({
                        type: "POST",
                        url: "/owner/category/delete/" + id,
                        success: function(response) {
                            loadsubdropdown();

                          $("#sina-alert").addClass( "alert-danger" ).text("Data deleted").show('slow');
                          window.setTimeout(function() {
                              $("#sina-alert").hide("slow").removeClass( "alert-danger" ).text("");
                          }, 2000);
                           $("[parentrowid="+id+"]").hide('slide', function(){ $("[parentrowid="+id+"]").remove(); });
                        },
                        error: function(error){
                                alert("Something went wrong");
                                location.reload();
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
