
<div id="tableRow{{{$table->id}}}">

	<div class="tableRow openModal 
		@if($table->is_occupied) 
			occupiedTable 
		@elseif($table->currentBooking->users->count() >0)
			tablePaused
		@else 
			{{{ $table->type->backgroundClass }}} 
		@endif" 

		target="{{{$table->id}}}" 
		method="tableSummary"
		style="width:{{{$table->widthAttr}}}vw">
		<div class="tableNumber centervertically">{{{ $table->number }}}</div>
		<div class="tableInfo">




			@if($table->is_occupied)
				<div 
					class="timeElapsed tableRowItem centervertically" 				
					data-target="{{{ $table->id }}}"
					data-baserate="{{{$table->currentBooking->base_hourly_rate}}}" 
					data-timeStart="{{{ $table->currentBooking->time_start }}}">
					<div class="tableRowItem"><!--Timer:--></div>
					<div class="tableRowItem">
						<div id="timerForTable{{{$table->id}}}">&nbsp;</div>
						<div id="costIncurredForTable{{{$table->id}}}">&nbsp;</div>
					</div>
				</div>
			@else

				<div class="tableName centervertically tableRowItem">
					@if($table->name)
						{{{ $table->name }}}
					@else
						
						{{{ $table->type->name }}}
					@endif
				</div>
				<div class="centervertically tableRowItem">
					
				</div>

			@endif

			@if($table->currentBooking->users->count() > 0)
				<div class="tableRowItem centervertically" style="float:right;">
					<div class="tableRowItem"><!--On Table:--></div>
					<ul class="usersOnTable tableRowItem">
						@if($table->currentBooking->users->count() > 2)
							@foreach($table->currentBooking->users->take(2) as $user)
								<li>{{{substr($user->fname.' '.$user->lname,0,13)}}}</li>
							@endforeach		
								<li>...</li>
						@else

							@foreach($table->currentBooking->users as $user)
								<li>{{{substr($user->fname.' '.$user->lname,0,13)}}}</li>
							@endforeach		

						@endif			

					</ul>
				</div>
			@endif
			




		</div>
	</div>
</div>