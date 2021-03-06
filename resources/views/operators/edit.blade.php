@extends('layouts.main-bootstrap')

@push('js')
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/admin/admin.css")}}">
@endpush

@section('content')
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

  <form action="/operators/{{$op->id}}" method="post"  enctype="multipart/form-data">
    @csrf
    <div class="row mt-3">
      <div class="col-12 text-center">
        <h1>Edit Operator</h1>
      </div>
    </div>

    <div class="row">
      <div class="card mt-3 col-12">
        <div class="properties container">
          <h2>Properties</h2>
          <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <input type="text" class="form-control" id="exampleInputEmail1" name="name" value="{{$op->name}}">
          </div>

          <div class="form-group">
              <label for="exampleInputEmail1">Icon</label>
              <input type="file" class="col-sm form-control" name="icon">
          </div>

          <div class="row" style="padding-left: 15px;">
            <div class="custom-control custom-switch col-4 col-xl-4 mt-3">
              @if($op->attacker)
                <input type="checkbox" checked class="custom-control-input" name="attacker" id="exampleCheck1">
                <label class="custom-control-label" for="exampleCheck1">Attacker</label>
              @else
                <input type="checkbox" class="custom-control-input" name="attacker" id="exampleCheck1">
                <label class="custom-control-label" for="exampleCheck1">Attacker</label>
              @endif
            </div>

            <div class="colour-pick col-8 col-xl-4 mt-3">
              <input type="color" name="colour" id="operator-color" value="{{$op->colour}}">
              <label for "operator-color">Operator Color</label>
            </div>
            <div class="col-12 col-xl-4 mt-3">
              <label class="" for="exampleCheck1">Gadget(s)</label>
              <select class="custom-select" name="gadgets[]" id="exampleCheck1" multiple>
                <option value="">None</option>
                @foreach($gadgets as $gadget)
                <option value="{{$gadget->id}}">{{$gadget->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="row justify-content-center mt-3 mb-3">
          <button type="submit" class="col-3 btn btn-success">Save</button>
        </div>
      </div>
    </div>
  </form>
  <form class="row mt-3 justify-content-center" action="/operators/{{$op->id}}/delete" method="post" onsubmit="return confirm('Are you sure you want to delete, this is irreversable?');">
    @csrf
    <button type="submit" class="col-3 btn btn-secondary">Delete Operator</a>
  </form>
</div>
@endsection
