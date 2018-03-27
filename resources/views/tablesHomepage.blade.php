@foreach($info['table_types'] as $type)
	<div class="equalwidth" style="width:{{{$info['colWidth']}}}vw">
		<h1>{{{ $type->name }}}</h1>
		<div class="availableContainer">
			@if($info[$type->id]['available']>0)
				<h4>{{{$info[$type->id]['available']}}} Tables Available</h4>
			@endif

			<div class="tables-available">
				@if($info[$type->id]['available']>0)			
					
					@foreach($type->tables->where('is_occupied','=',0) as $table)
						<?php $table->widthAttr =  $info['rowWidth'];?>
						@include('terminal.loopTemplates.tableRow',['table'=>$table])
						
					@endforeach

				@else
					No Tables Available
				@endif
			</div>

		</div>
		<div class="availableBorder"></div>
		@if($type->tables->where('is_occupied','=',1)->count()>0)
			<div class="occupiedContainer">
				<h4>Occupied</h4>			

				<div class="tables-occupied">

					@foreach($type->tables->where('is_occupied','=',1) as $table)
						<?php $table->widthAttr =  $info['rowWidth'];?>
						@include('terminal.loopTemplates.tableRow',['table'=>$table,'rowWidth'=>$info['rowWidth']])
						
					@endforeach
				
				</div>
			</div>
		@endif
	</div>
@endforeach