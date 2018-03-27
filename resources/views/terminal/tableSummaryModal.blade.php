@extends('layouts.modalLayout')

@section('headerContent')
	<div class="modalTitleHolder">
        <h2 class="modalTitle">Table {{{ $data['target']->number.' - '}}}{{$data['target']->name? $data['target']->name : $data['target']->type->name}}</h2>
    </div>
    <div id="historyButton" target="{{{$data['target']->id}}}">History</div>

@endsection


@section('lefthalf')
	<h2>Search</h2>
	<div id="searchRow">
		Search for Member:<input type="textbox" placeholder="Search..." id="seachBox" target="{{{ $data['target']->id }}}">    		
	</div>
	<div id="memberSearchResults">
		@include('terminal.modal.memberSearchResults',['data'=>$data])

	</div>

	<div class="btn" id="scanIDButton">Scan ID</div>
@endsection

@section('righthalf')
	<h2>On Table</h2>
	<div id="membersOnTable">

		<table id="tableOfMembersOnTable">
			<thead>
				<tr>
					<th><!-- img --></th>
					<th>Name</th>					
					<th></th>
				</tr>
			</thead>
			<tbody>
				@if($data['usersOnTable'])
					@foreach($data['usersOnTable'] as $user)

						<tr>
							<td class="userThumb" target="{{{ $user->id }}}" style="background-image:url('{{{ $user->profileThumb() }}}');">
								<div id="enlargedProfilePic1" class="userPicEnlarged" style="background-image:url('{{{ $user->profileMedium() }}}');"></div>
							</td>

							<td>{{{substr($user->fname.' '.$user->lname,0,13)}}}</td>

							@if($data['usersOnTable']->count() >1)
							<td class="userOnTable action" method="removeUserFromTable" targetTable="{{{ $data['target']->id }}}" targetUser="{{{ $user->id }}}">Remove</td>
							@else
							<td></td>
							@endif

						</tr>

					@endforeach
				@endif
				
			</tbody>
		</table>
	</div>
	<div id="tablePricingSummary">
		<table>
			<tr>
				<td>Price</td>
				<td colspan="2">£{{{number_format((float)$data['target']->currentHourlyRate()/100, 2, '.', '')}}} / hr</td>
			</tr>
			<tr>
				@if($data['target']->is_occupied)
					<td 
							class="timeElapsed" 
							data-target="{{{ $data['target']->id }}}s"
							data-baserate="{{{ $data['target']->currentBooking->base_hourly_rate}}}" 
							data-timeStart="{{{ $data['target']->currentBooking->time_start }}}"
							data-cancellimit="{{{$data['cancelLimit']}}}"
							data-cancelButton="{{{$data['target']->id}}}canx"
							>
						Timer
					</td>
					<td id="timerForTable{{{$data['target']->id}}}s"></td>
					<td id="costIncurredForTable{{{$data['target']->id}}}s"></td>
				@else
					<td>
						Timer
					</td>
					<td>-</td>
					<td>&pound;-</td>
				@endif
			</tr>
		</table>
	</div>
	<div id="tableActionButtons">

		@if($data['target']->is_occupied && \App\config::where('name','=','canPauseTable')->first()->boolean)
			<div class="btn tableAction" target="{{{ $data['target']->id }}}" method="pauseTable">Pause<br>Table</div>
		@endif

		@if($data['target']->is_occupied)
			<div class="btn tableAction" target="{{{ $data['target']->id }}}" method="stopTable">Stop<br>Table</div>
		@endif

		@if((time() - $data['target']->currentBooking->time_start) < \App\config::where('name','=','timeToCancelTable')->first()->integer)
			<div id="{{{$data['target']->id}}}canx" class="btn tableAction" target="{{{ $data['target']->id }}}" method="cancelTable">Cancel<br>Table</div>
		@endif
    	</div>
@endsection
