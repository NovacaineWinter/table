	<table id="memberTable">
		<thead>
			<tr>
				<th><!-- img --></th>
				<th>Name</th>
				<th>Membership</th>
				<th>Notes</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

		@foreach($data['users'] as $user)	
			<tr>
				<td class="userThumb" target="{{{ $user->id }}}" style="background-image:url('{{{ $user->profileThumb() }}}');">
					<div id="enlargedProfilePic1" class="userPicEnlarged" style="background-image:url('{{{ $user->profileMedium() }}}');"></div>
				</td>

				<td>{{{substr($user->fname.' '.$user->lname,0,13)}}}</td>
				<td>301 Days left</td>
				<td>No ID Card</td>
				@if($user->hasErrors())
					<td class="errorInAddingUserToTable action" targetTable="{{{ $data['target']->id }}}" targetUser="{{{ $user->id }}}">Add To Table</td>
				@else
					<td class="userOnTable action" method="addUserToTable" targetTable="{{{ $data['target']->id }}}" targetUser="{{{ $user->id }}}">Add To Table</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>