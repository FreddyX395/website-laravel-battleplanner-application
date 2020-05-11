@extends('layouts.main')

@push('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
var floorNum = 0;

  function del(button){
    $(button).parent("li").addClass("d-none");
    $(button).parent("li").remove();
  }


  function addFloor(){
      var dom = $("#sample-floor-form").clone();
      dom.removeClass("d-none");
      dom.attr("id",floorNum);
      dom.children("#floor-number").attr("value", floorNum);
      floorNum++;
      $("#floor-list").append(dom);
  }

</script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/admin/admin.css")}}">
@endpush

@section('content')
@include('map.floor-form', ["floorPreview" => "", "floorName" => "", "floorId" => ""])


<div class="container">

  @if ($errors->any())
    @foreach ($errors->all() as $error)
      <div class="row mt-3 justify-content-center">
        <div class="col-12 alert alert-danger" role="alert">
          {{ $error }}
        </div>
      </div>
      @endforeach
  @endif

  <form action="/map" method="post"  enctype="multipart/form-data">
    @csrf
    <div class="row mt-3">
      <div class="col-12 text-center">
        <h1>New Map</h1>
      </div>
    </div>

    <div class="row">
      <div class="card mt-3 col-12">
        <div class="properties container">
          <h2>Properties</h2>
          <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Map Name" required>
          </div>

          <div class="form-group">
              <label for="exampleInputEmail1">Thumbnail</label>
              <input type="file" class="col-sm form-control" name="thumbnail" required>
          </div>

          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" name="is_competitive" id="exampleCheck1">
            <label class="custom-control-label" for="exampleCheck1">Competitive Playlist</label>
          </div>
        </div>

        <div class="floors container">
          <h2>Floors</h2>
          <button type="button" class="col-12 btn btn-success m-1" onclick="addFloor()">Add floor</button>
          <ul class="list-group" id="floor-list"></ul>
        </div>

        <button type="submit" class="col-12 btn btn-success">Save</button>
      </div>
    </div>
  </form>
</div>
@endsection
