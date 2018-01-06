@extends('layout.app')

@section('main-app')

<div id="register_box">
	<h2>Complete your new Masakuy Account.</h2>
	<form method="post" enctype="multipart/form-data" action="{{url('/register/step2')}}">
	<div class="row">
		<div class="col col-3">
			<img src="{{url('profile/no-profile.svg')}}" class="img-responsive">
			<input type="file" name="imgProfile" id="imgUpload" style="display:none;">
			<input type="button" class="btn btn-sm btn-success btnupload" onclick="$('#imgUpload').click()" value="Upload New Image">
		</div>
		<div class="col">
			<div class="form-group">
				<label>Email Address:</label>
				@if (Session::has('email'))
				<input type="email" name="email" class="form-control" disabled value="{{Session::get('email')}}">
				@endif
			</div>

			<div class="form-group">
				<label>Name:</label>
				@if (Session::has('nama'))
				<input type="text" name="nama" class="form-control" value="{{Session::get('nama')}}">
				@else
				<input type="text" name="nama" class="form-control">
				@endif
				@if (Session::has('error_nama'))
				<span class="error text-danger">Name is required !</span>
				@endif
			</div>

			<div class="form-group">
				<label>Custom Profile Url:</label>
				@if (Session::has('custom_profile'))
				<input type="text" name="custom_profile" class="form-control" value="{{Session::get('custom_profile')}}">
				@else
				<input type="text" name="custom_profile" class="form-control">
				@endif
				@if (Session::has('error_cp'))
				<span class="error text-danger">Custom Profile Required or Has Been Taken</span>
				@endif
			</div>

			<div class="form-group">
				<label>Gender</label>
				<div class="radio">
					<label><input type="radio" name="gender" value="M"
						@if(Session::get('gender')=='M')
							checked
						@endif 
						> Male</label>
					<label><input type="radio" name="gender" value="F"
						@if(Session::get('gender')=='F')
							checked
						@endif
						> Female</label>
				</div>
				@if (Session::has('error_gender'))
				<span class="error text-danger">Gender is Required !</span>
				@endif
			</div>

			<div class="form-group">
				<label>Date of Birth</label>
				@if (Session::has('dob'))
				<input type="date" name="dob" class="form-control" value="{{Session::get('dob')}}">
				@else
				<input type="date" name="dob" class="form-control">
				@endif
				@if (Session::has('error_dob'))
				<span class="error text-danger">Date of Birth is Required !</span>
				@endif
			</div>

			<button class="btn btn-primary">Continue to Step 2</button>
		</div>
	</div>
	</form>
</div>

@endsection