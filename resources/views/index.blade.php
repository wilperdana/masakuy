@extends('layout.app')

@section('main-app')
<span class="welcome_msg">Your Cooking Dream <span class="merah bold">Starts Here</span></span>
<span class="welcome_msg_sm">Search for recipes at Masakuy in one click.</span>
<div id="welcome_searchbox_cont">
	<form method="post" action="{{url('/search/')}}">
		<input type="search" name="textSearch" class="welcome_searchbox" placeholder="Search Recipes or Masakuy User Here">
	</form>
</div>

<div id="featured_home">
	<div id="featured_home_cont">
		<span class="featured_title">Our Featured Recipes:</span>
		<div id="featured_menu">
			@foreach($recipes as $recipe)
			<a href="{{url('/recipe/' . $recipe->recipeCustomURL)}}">
			<div id="featured_on">
				<div class="featured_img" style="background: url({{url('recipes/' . $recipe->recipeImageURL)}}) no-repeat center; background-size: cover;"></div>
				<span class="featured_desc">{{$recipe->recipeName}}</span>
			</div>
			</a>
			@endforeach
		</div>
	</div>
</div>
@endsection