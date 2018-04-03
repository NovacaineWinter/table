	<table id="memberTable">
		<thead>
			<tr>
				<th><!-- img --></th>
				<th>Name</th>
				<th>Address</th>
				<th>Postcode</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

		@foreach($data['users'] as $user)	
			<tr id="rowSearchResultForMember{{{$user->id}}}"
				@if($user->currently_playing) class="memberPlaying" @endif >
				<td class="userThumb" target="{{{ $user->id }}}" style="background-image:url('{{{ $user->profileThumb() }}}');">
					<!--<div id="enlargedProfilePic{{{ $user->id }}}" class="userPicEnlarged" style="background-image:url('{{{ $user->profileMedium() }}}');"></div>-->
				</td>

				<td>{{{substr($user->fname.' '.$user->lname,0,13)}}}</td>
				<td>{{{substr($user->addr_line_one.' '.$user->addr_line_two,0,15)}}}</td>
				<td>{{{$user->postcode}}}</td>
				@if($user->hasErrors())
					<td class="errorInAddingUserToTable action" targetTable="{{{ $data['target']->id }}}" targetUser="{{{ $user->id }}}">Add To Table</td>
				@else
					<td class="userOnTable action" method="addUserToTable" targetTable="{{{ $data['target']->id }}}" targetUser="{{{ $user->id }}}">Add To Table</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>