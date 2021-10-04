@extends('layouts.owner');
@section('css')
<style>


</style>
@endsection
@section('content')

<div class="card">
	<div class="card-header">
        <h5>Color Size Group</h5>
    </div>

    <div class="card-body">
        <div class="top-buttons">
            <div class="add-buttons align-items-right">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#colorGroupModal">
                    Add Color Group
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sizeGroupModal">
                    Add Size Group
                </button>
            </div>
        </div>

        <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#color" role="tab" aria-controls="color" aria-selected="true">Color Group</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#size" role="tab" aria-controls="size" aria-selected="false">Size Group</a>
            </li>
        </ul>

          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="color" role="tabpanel" aria-labelledby="home-tab">
                <table class="table">
                    <tr>
                        <th>Group Name</th>
                        <th>Colors</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($colors as $color)
                        <tr>
                            <td>{{$color->name}}</td>
                            <td>
                                @if($color->get_child)
                                    @foreach ($color->get_child as $ch)
                                        <span class="d-flex"><div style="margin-right:5px; width: 20px; height: 20px; background-color: {{$ch->name}}"></div> {{$ch->name}}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <button data-id="{{$color->id}}" data-type="color" class="btn btn-primary color-size-edit">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="tab-pane fade" id="size" role="tabpanel" aria-labelledby="profile-tab">
                <table class="table">
                    <tr>
                        <th>Group Name</th>
                        <th>Sizes</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($sizes as $size)
                        <tr>
                            <td>{{$size->name}}</td>
                            <td>
                                @if($size->get_child)
                                    @foreach ($size->get_child as $ch)
                                        <span class="d-flex">{{$ch->name}}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <button data-id="{{$size->id}}" data-type="size" class="btn btn-primary color-size-edit">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
          </div>
    </div>
</div>


  <!-- Modal -->
  <div class="modal fade" id="colorGroupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Color Group</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('color.size.group.store')}}" method="post">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="type" value="1">
                <div class="form-group">
                    <label for="">Color Group Name</label><br>
                    <input type="text" class="form-control" required placeholder="Color Group Name" name="group_name">
                </div>
                <div class="form-group">
                    <label for="">Colors</label><br>
                    <input type="text" placeholder="Colors" required data-role="tagsinput" class="form-control values" name="values">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Size Group -->
  <div class="modal fade" id="sizeGroupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Size Group</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('color.size.group.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="type" value="2">
                    <div class="form-group">
                        <label for="">Size Group Name</label><br>
                        <input type="text" required class="form-control" placeholder="Size Group Name" name="group_name">
                    </div>
                    <div class="form-group">
                        <label for="">Size</label><br>
                        <input type="text" required class="form-control" placeholder="Colors" data-role="tagsinput" name="values">
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>


  {{-- Edit modal  --}}
  <div class="modal fade" id="EditColorSizeGroupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title edit_modal_title" id="exampleModalLabel">Size Group</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('color-size-group.update')}}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" class="edit_type" name="type" value="">
                    <input type="hidden" class="parent_id" name="parent_id" value="">
                    <div class="form-group">
                        <label for="">Group Name</label><br>
                        <input type="text" required class="form-control group_name" placeholder="Size Group Name" name="group_name">
                    </div>

                    <div class="form-group">
                        <label for="">Group Values</label><br>
                        <div class="group_edit_data"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Add More</label><br>
                        <input type="text" placeholder="Add New" data-role="tagsinput" class="form-control values" name="add_values">
                    </div>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>

@endsection


@section('js')

  <script>

      $(document).ready(function(){

        $('.color-size-edit').click(function(){
            var id = $(this).attr('data-id');
            var type = $(this).attr('data-type');
            console.log(type);

            $.ajax({
                url:"/owner/color_size_group_edit",
                type:"GET",
                data: {
                    id: id, type: type
                },
                success:function (response) {
                    $('#EditColorSizeGroupModal').modal('show');

                    $('.group_name').val(response.name);
                    $('.parent_id').val(response.id);
                    $('.edit_type').val(response.type);

                    if(type == 'color')
                        $('.edit_modal_title').text("Edit Color Group");
                    else
                        $('.edit_modal_title').text("Edit Size Group");


                    data = '';
                    $.each(response.get_child, function(key, value) {
                        data += '<div class="d-flex justify-content-between child_'+value.id+'"><input type="hidden" name="child_id[]" value="'+ value.id +'"><input type="text" required class="form-control mt-2" value="'+ value.name +'" placeholder="Name" name="child_values[]"><button type="button" onclick="child_delete('+ value.id +')" data-id="" class="child_delete btn btn-danger my-2 ml-2 btn-sm">Delete</button></div>';
                    })

                    $('.group_edit_data').html(data);
                }
            })
        });


        // $('.child_delete').click(function(v){
        //     // $(this).closest("div").hide();

        //     var id = v;

        //     console.log('id');
        // });
      });

    function child_delete(v){
        if(confirm("It Will Delete Permanently")){
            $(".child_"+v).remove();

        $.ajax({
                url:"/owner/color_size_group_delete",
                type:"POST",
                data: {
                    id: v
                },
                success: function(response){
                    console.log(response);
                }
            });
        }
    }

  </script>

@endsection
