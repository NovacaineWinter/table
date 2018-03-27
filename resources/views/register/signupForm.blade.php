@extends('layouts.app')

@section('content')


<form enctype="multipart/form-data" method="post" action="{{url('recieve')}}">
    {{ csrf_field() }}
    
     <div class="form-group">
        <label for="imageInput">File input</label>
        <input type="file" accept="image/*;capture=camera" name="input_img">
    </div>

    <div class="form-group">
        <label for="">submit</label>
        <input class="form-control" type="submit">
    </div>
</form>

@endsection