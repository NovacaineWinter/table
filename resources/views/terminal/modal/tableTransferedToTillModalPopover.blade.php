@extends('layouts.modalPopoverLayout')

@section('popoverHeader')
	<h2>Transfered To Till</h2>
@endsection


@section('content')
	Table has been transfered to the Till. 

	@if($info['discount'])
		The Following discounts were applied;
		{{{$info['comments']}}}
	@endif

	<table>
		<tr>
			<td>Total Cost;</td>
			<td>&pound;{{{$info['cost']}}}</td>			
		</tr>
	</table>
@endsection