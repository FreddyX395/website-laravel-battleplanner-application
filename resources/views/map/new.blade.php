@extends('layouts.main')

@push('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

    function del(id){
        $("#" + id).remove();
    }

    function addFloor(){

        // var li = document.createElement("li");
        // $(li).addClass("col-12 text-center row");
        // li.setAttribute("id", "floor-"+$("#floor-list li").length);

        // li.innerHTML = '<i class="fas fa-bars"></i>'

        // var y = $("#add-floor-file").clone();
        // y.attr("name", "floor-files[" + $("#floor-list li").length+"]");
        // y.appendTo(li)

        // var x = $("#add-floor-name").clone();
        // x.attr("name", "floor-names[" + $("#floor-list li").length+"]");
        // x.appendTo(li)
        
        // li.innerHTML += "<i class=\"fas fa-trash-alt\" onclick=\"del('floor-"+$("#floor-list li").length+"')\"></i>"

        var dom = $("#sample-floor-form").clone();
        dom.removeClass("d-none");
        dom.attr("id",'');

        $("#floor-list").append(dom);
    }

    
  $( function() {
    $( ".sortable" ).sortable();
    $( ".sortable" ).disableSelection();
  } );

  
</script>
@endpush

@push('css')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
      .fa-bars{
        font-size: 50px;
        margin-right: 10px;
      }

      .fa-trash-alt{
        color:red;
        font-size: 50px;
        margin-left: 10px;
      }
  </style>
@endpush

@section('content')


<div class="justify-content-center">

    <!-- Template for floor -->
    <!-- <div class="form-group d-none">
        <h3 class="text-center">Add Floor to list</h3>
        <div class="col-12 text-center new-floor-block row">
            <input type="file" class="col-sm form-control" id="add-floor-file" required>
            <input type="text" class="col-sm  form-control" id="add-floor-name" aria-describedby="emailHelp" placeholder="Floor Name" required>
        </div>
    </div> -->
    @include('map.floor-form', ["floorPreview" => "", "floorName" => "", "floorId" => ""])

    <div class="col-8">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                {{ $error }}
                </div>
            @endforeach
        @endif

        <form action="/map" method="post"  enctype="multipart/form-data">
        @csrf
        <h1 class="text-center">Create Map</h1>
        <h2>Properties</h2>
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp" placeholder="Map Name" required>
        </div>
        
        <div class="form-group">
            <label for="exampleInputEmail1">Thumbnail</label>
            <input type="file" class="col-sm form-control" name="thumbnail" required>
        </div>
        
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="is_competitive" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Competitive Playlisted</label>
        </div>

        <hr>
        <h2>Floors</h2>



        <small>1. Order Matters: Lowest floor at the top of list, highest at the bottom of list</small><br>
        <small>2. List can be organized by clicking and dragging elements</small>
        <br>
        
        <button type="button" class="col-12 btn btn-success m-1" onclick="addFloor()">Add floor</button>
        <ul class="list-group sortable" id="floor-list"></ul>

        <hr>

        <button type="submit" class="col-12 btn btn-primary">Save</button>
        </form>
    </div>
    <br>
</div>
@endsection