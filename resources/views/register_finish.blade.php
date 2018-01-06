@extends('layout.app')

@section('main-app')

<div id="register_box">
	<h2>You're All Set !</h2>
	<div class="row">
		<div class="col tekstengah">
			<form method="get" action="{{url('/')}}">
				<img src="{{url('img/success.png')}}" style="height:300px; width: 300px;"> <br>
				Congratulations ! Your account has been created. <br><br>
				<button class="btn btn-success">Masak Kuy !</button>
			</form>
		</div>
	</div>
</div>

@endsection