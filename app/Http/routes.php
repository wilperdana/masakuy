<?php

Route::get('/', 'PageController@home');
Route::get('/sample/view', function() {
	return view('recipes.view');
});

Route::get('/user/{username}', 'PageController@viewProfile');
Route::get('/user/{username}/following', 'PageController@showFollowing');
Route::get('/user/{username}/followers', 'PageController@showFollowers');

Route::get('/recipe/{recipename}', 'RecipeController@viewRecipe');
Route::post('/search', 'PageController@searchRecipe');

Route::group(['middleware' => 'guest-middleware'], function() {
	Route::get('/login', 'PageController@login');
	Route::post('/auth/doLogin', 'PageController@doLogin');

	Route::post('/register', 'PageController@doRegister');

	Route::get('/register', function() {
		return view('register');
	});

	Route::post('/register/step2', 'PageController@registerStep2');

	Route::get('/register/step2', function() {
		return view('register_step2');
	});

	Route::post('/register/step3', 'PageController@finishRegister');

	Route::get('/register/finish', function(){
		return view('register_finish');
	});
});


Route::group(['middleware' => 'member-middleware'], function() {
	Route::get('/recipes/new', 'RecipeController@createNew');
	Route::post('/recipes/doCreate', 'RecipeController@doCreate');

	Route::get('/doLike/{recipeID}', 'RecipeController@doLikeRecipe');
	Route::get('/doUnlike/{recipeID}', 'RecipeController@doUnlikeRecipe');

	Route::post('/addComment/{recipeID}', 'RecipeController@addComment');
	Route::get('/comment/delete/{commentID}/{recipeID}', 'RecipeController@deleteComment');

	Route::get('/logout', 'PageController@doLogout');

	Route::get('/user/follow/{id}', 'PageController@doFollow');
	Route::get('/user/unfollow/{id}', 'PageController@doUnfollow');
	Route::get('/profile/edit', 'PageController@editProfile');
	Route::post('/profile/saveNew', 'PageController@saveProfile');
	Route::get('/recipe/{recipename}/edit', 'RecipeController@editRecipe');
	Route::post('/recipe/doEdit/{recipeID}', 'RecipeController@doEdit');

	Route::get('/feeds', 'PageController@showFeeds');
});