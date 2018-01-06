@extends('layout.app')

@section('main-app')
<div id="searches">
	<h2>Edit Profile</h2>
	<div id="profile_recipe" style="background: white; height: auto;">
		<form method="post" action="{{url('/profile/saveNew')}}" enctype="multipart/form-data" >
			{{csrf_field()}}
			<table class="table" style="width:78%;">
				<tr>
					<td style="width:15%;">Name</td>
					<td style="width:3%;">:</td>
					<td style="width:60%;">
						<input type="text" name="nama" class="form-control" value="{{$user->userName}}">
						@if($errors->has('nama'))
						<small class="alert text-danger">Name is required !</small>
						@endif
					</td>
				</tr>
				<tr>
					<td>Gender</td>
					<td>:</td>
					<td>
						<div class="radio">
						<label><input type="radio" name="gender" value="M"
							@if($user->userGender=="M")
								checked
							@endif 
							> Male</label>
						<label><input type="radio" name="gender" value="F"
							@if($user->userGender=="F")
								checked
							@endif
							> Female</label>
					</div>
					</td>
				</tr>
				<tr>
					<td>Username</td>
					<td>:</td>
					<td>
						<input type="text" name="userUsername" class="form-control" value="{{$user->userUsername}}">
						@if($errors->has('userUsername'))
						<small class="alert text-danger">Username already exists !</small>
						@endif
					</td>
				</tr>
				<tr>
					<td>Date of Birth</td>
					<td>:</td>
					<td>
						<input type="date" name="dob" class="form-control" value="{{$user->userDOB}}">
						@if($errors->has('dob'))
						<small class="merah">Date of Birth is Required !</small>
						@endif
					</td>
				</tr>
				<tr>
					<td>Bio</td>
					<td>:</td>
					<td>
						<textarea name="bio" rows="3" class="form-control">{{$user->userBio}}</textarea>
						@if($errors->has('bio'))
						<small class="alert text-danger">Bio is required !</small>
						@endif
					</td>
				</tr>
				<tr>
					<td>New Profile Image</td>
					<td>:</td>
					<td>
						<input type="file" name="profileImage" class="form-control">
						<small>If You don't want to change profile image, leave this.</small>
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td><button class="btn btn-primary btn-md"><i class="fa fa-save"></i> Save New Profile</button></td>
				</tr>
			</table>
		</form>
	</div>
</div>

	
@endsection