@extends('layout.app')

@section('main-app')

<div id="register_box">
	<h2>Complete your new Masakuy Account.</h2>
	<div class="row">
		<div class="col">
			<form method="post" action="/register/step3" enctype="multipart/form-data">
				{{csrf_field()}}
				<div class="form-group">
					<label>Describe your personal bio:</label>
					<textarea class="form-control" name="bio" rows="5"></textarea>
				</div>
				<button class="btn btn-primary">Finish Setting Up Account</button>
			</form>
		</div>
	</div>
</div>

@endsection