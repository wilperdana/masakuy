@extends('layout.app')

@section('main-app')
<div id="searches" style="margin-bottom: 30px;">
	<h2>Feeds from your Following</h2>

	@if($recipes->count()==0)	
		<span>No Feeds available</span>
	@endif

	@foreach ($recipes as $recipe)
		@php
			$count = App\Friends::where([
				['friendDest', '=' , $recipe->userID],
				['friendSource', '=', Session::get('userActive')]
			])->count();
		@endphp

		@if($count==0)
			@continue
		@endif

		@php
			$likes = App\Likes::where('recipeID', $recipe->recipeID)->count();
		@endphp
		<div id="profile_recipe" style="background: white;">
			<div id="profile_recipe_img">
				<img src="{{asset('/recipes/' . $recipe->recipeImageURL)}}">
			</div>

			<div id="profile_recipe_info">
				<span class="profile_recipe_name"><a href="{{url('/recipe/' . $recipe->recipeCustomURL)}}">{{$recipe->recipeName}}</a></span>
				<span class="profile_recipe_stats">
					<img src="{{url('img/love.png')}}" class="img_love"> {{$likes}} Likes<br>
					<img src="{{url('img/eye.png')}}" class="img_love"> {{$recipe->recipeViews}} Views <br>
					<i class="fa fa-user"></i> <a href="{{url('/user/' . $recipe->user_info['userUsername'])}}">{{$recipe->user_info['userName']}}</a>
				</span>
			</div>
		</div>
	@endforeach

	<div id="profile_recipe_info">
	{{ $recipes->links() }}
	</div>
</div>

	
@endsection