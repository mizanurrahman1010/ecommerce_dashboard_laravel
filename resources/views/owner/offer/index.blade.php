@extends('layouts.owner')
@section('content')
    <div class="card ml-5 mr-5">
        <div class="card-header">
            <div class="d-flex">
                <div class="p-2">
                    <form action="{{route('owner.offer.index')}}" method="get">
                        <h4>Offers</h4>
                        <select name="offer_type" class="form-control mb-1">
                            @foreach($list as $val)
                                <option value="{{$val->id}}">
                                    {{$val->name}}
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary btn-sm">
                            Search
                        </button>
                    </form>
                </div>
                <div class="p-2">
                    <label>Status</label>
                    <div>
                        <select class="form-control" name="status">
                            <option value="1">Show</option>
                            <option value="2">Hide</option>
                        </select>
                    </div>
                </div>
                <div class="ml-auto p-2">
                    <a href="{{route('owner.offer.create')}}">New</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card">
                
                    @foreach($offers as $pi)
                        <div class="row">
                            <?php 
                                $images=explode(",",$pi->images);
                            ?>
                            <div class="col-12 d-flex align-items-end p-3">
                                <div class="d-flex">
                                    <div class="p-2">
                                        <h2>{{$pi->name}}</h2>
                                    </div>
                                    <div class="ml-auto p-2">
                                        <a 
                                            href="{{url('owner/offer/create?id=')}}<?=$pi->id ?>" 
                                            class="btn btn-secondary btn-sm edit-btn" >Edit</a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row d-flex align-items-end p-3 justify-content-center">
                                <?php for($i=0;$i < count($images);$i++): ?>
                                    <?php 
                                        if(empty($images[$i]))
                                            continue;    
                                    ?>
                                    <div class="col-2">
                                        <div class="card mb-0">
                                            <div class="card-img-top">
                                                <img style="max-width: 100%" 
                                                    src="<?php echo viewS3Image(helperAwsLocation(8)."".$images[$i])  ?>" alt="">
                                            </div>
                                            <div class="d-flex justify-content-center pt-2">
                                                <a 
                                                    href="{{url('owner/offer/create?id=')}}<?=$pi->id ?>&pid=<?=$images[$i] ?>" 
                                                    class="btn btn-secondary btn-sm edit-btn" >Edit</a>

                                                <button data-img="<?=$images[$i] ?>" type="button" onclick="deleted(this,{{$pi->id}})" class="btn btn-danger btn-sm ml-1">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?> 
                            </div>       
                        </div> 
                    @endforeach
                     
            </div>
        </div>
@endsection
@section('js')
<script>
    function deleted(v,id)
        {
            var img=$(v).attr("data-img");
            $.confirm({
                title: 'Are you sure?',
                content: 'This is Permanent Delete.',
                product: 'red',
                productAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Delete Now',
                        btnClass: 'btn-red',
                        action: function(){


                            delFinal(img,id);

                            //window.location.href = '{{ route('owner.offer.image.delete') }}/'+id;
                        }
                    },
                    close: function () {
                    }
                }
            });
        }
    function delFinal(img,id)
    {

        var alertData={showLoading:'true',title:"Loading...",
            tpb: true,position:'center',aoc:false};
        sweetAlert(alertData);

        $.ajax({
                url: '/owner/offer/image/delete',
                type: 'post',
                data: {id:id,img:img},
                success: function(res){
                    var alertData={title:res.msg,timer:1000,toast: true};
                    sweetAlert(alertData);
                    if(res.status == 1)
                        window.location.reload();
                    
                }
            });
    }    
</script>
@endsection
