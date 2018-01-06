@extends('layout.app')

@section('main-app')

<script type="text/javascript">
    $(document).ready(function() {
        toggleLogin();
    });
</script>
<div id="login_box">
	<div id="login_section">
		<h2>Login to your Masakuy Account !</h2>
		<form method="post" enctype="form" action="{{ url('/auth/doLogin') }}">
			{{csrf_field()}}
			<div class="form-group">
				<label>Email Address</label>
				<input type="email" class="form-control" name="emailLogin" placeholder="Email Address">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" class="form-control" name="passwordLogin" placeholder="Password">
			</div>
			<button class="btn btn-primary">Login</button>
		</form>
		<small><a href="#" onclick="toggleRegister()">Don't have account ? Create One</a></small>
	</div>

	<div id="register_section">
		<h2>Register a New Account</h2>
		<form method="post" enctype="form" action="{{ url('/register') }}">
			{{csrf_field()}}
			<div class="form-group">
				<label>Email Address</label>
				<input type="email" class="form-control" name="email" placeholder="Email Address"
					value="{{old('email')}}"
				>
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" class="form-control" name="password" placeholder="Password">
			</div>
			<div class="form-group">
				<label>Confirm Password</label>
				<input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
			</div>
			<button class="btn btn-primary">Register</button>
		</form>

		<small><a href="#" onclick="toggleLogin()">Already have account ? Login</a></small>
	</div>

</div>

@if($errors->any())
<script type="text/javascript">
    $(document).ready(function() {
        toggleRegister();
    });
</script>
@endif

@if($errors->any())
<div class="alert alert-danger alerttengah">
	@if ($errors->has('password'))
		Password Confirmation does not match
	@elseif ($errors->has('email'))
		Email has already taken before !
	@endif
</div>
@endif

@if(session('statusFail'))
<div class="alert alert-danger alerttengah">
	Invalid email or password
</div>
@endif

@endsection