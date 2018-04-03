@extends('layouts.modalPopoverLayout')


@section('popoverHeader')
	<h2 class="text-center">{{{$user->fname.' '.$user->lname}}}</h2>
@endsection


@section('content')
	<img class="enlargedProfilePicPopover" src="{{{$user->img_raw}}}" alt="Profile Picture">
@endsection