@extends('layouts.dataView')

@section('content')

    <div id="postcode_lookup"></div>
<form enctype="multipart/form-data" method="post" action="{{url('recieve')}}">
    {{ csrf_field() }}
   






    <div class="form-group">
        <input type="text" name="fname" placeholder="First Name">
        <input type="text" name="lname" placeholder="Last Name">
    </div>


 	<div class="form-group">
        <input type="email" name="email" placeholder="Email">
        <input type="text" name="phone" placeholder="Phone">
    </div>


    <div class="form-group">
        <input type="text" class="toReveal" name="addr_line_one" placeholder="Address Line One" id="line1">
    </div>

  	<div class="form-group">
        <input type="text" class="toReveal" name="addr_line_two" placeholder="Address Line Two" id="line2">
    </div>

    <div class="form-group">
        <input type="text" class="toReveal" name="town" placeholder="Town" id="town">
    </div>

    <div class="form-group">
        <input type="text" class="toReveal" name="county" placeholder="County" id="county">
    </div>

    <div class="form-group">
        <input type="text" class="toReveal" name="postcode" placeholder="Postcode" id="postcode">
    </div>
    <!--

     <div class="form-group">
        <label for="imageInput">File input</label>
        <input type="file" accept="image/*;capture=camera" name="input_img">
    </div>

	-->


    <div class="form-group">
        <input class="form-control" type="submit" value="Next">
    </div>
</form>




@endsection