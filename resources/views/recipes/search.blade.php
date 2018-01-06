@extends('layout.app')

@section('main-app')
<div id="searches" style="margin-bottom: 30px;">
	<h2>{{$searchCount+$users->count()}} search results</h2>

	<div id="profile_recipe" style="height:auto;">
		<form method="post" action="{{url('/search/')}}">
			<input type="search" name="textSearch" class="welcome_searchbox" placeholder="Search Recipes Here" style="width:100%; font-size:15px; padding-left: 35px;" value="{{$query}}">
		</form>
	</div>

	@foreach ($users as $user)
		@php
			$followingCount = App\Friends::where('friendSource', $user->userID)->count();
		 	$followersCount = App\Friends::where('friendDest', $user->userID)->count();
		@endphp
		<div id="profile_recipe" style="background: white;">
			<div id="profile_recipe_img">
				<img src="{{asset('/profile/' . $user->userProfileURL)}}" style="width:100px; float: left;">
			</div>

			<div id="profile_recipe_info" style="margin-left:-35px;">
				<span class="profile_recipe_name" style="margin-bottom:-20px;"><a href="{{url('/user/' . $user->userUsername)}}">{{$user->userName}}</a></span> <br>
				<span class="profile_recipe_stats">
					Following : {{$followingCount}}<br>
					Followers : {{$followersCount}}<br>
					Member Since : {{date('d M Y', strtotime($user->userDateCreated))}}<br>
				</span>
			</div>
		</div>
	@endforeach

	@foreach ($recipes as $recipe)
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
					<img src="{{url('img/eye.png')}}" class="img_love"> {{$recipe->recipeViews}} Views
				</span>
			</div>
		</div>
	@endforeach

	<div id="profile_recipe_info">
	{{ $recipes->links() }}
	</div>
</div>

	
@endsection