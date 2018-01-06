@extends('layout.app')

@section('main-app')
<div id="profiles">
	<div id="profile_head">
		<div id="profileimg">
			<img src="{{asset('/profile/' . $user->userProfileURL)}}">
		</div>

		<div id="profileinfo">
			<div id="profilename">{{$user->userName}}</div>
			<div id="profilebio">{{$user->userBio}}</div>
			@if(Session::has('userActive'))
			@if(Session::get('userActive')!=$user->userID)
			@if(App\Friends::where([ ['friendSource', '=', Session::get('userActive')], ['friendDest', '=', $user->userID] ])->count())
				<form method="get" action="{{url('/user/unfollow/' . $user->userID)}}">
					<button class="btn btn-danger btn-sm"><i class="fa fa-minus"></i> Unfollow</button>
				</form>
			@else
				<form method="get" action="{{url('/user/follow/' . $user->userID)}}">
					<button class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Follow</button>
				</form>
			@endif
			@endif
			@endif

			@if(Session::get('userActive')==$user->userID)
				<form method="get" action="{{url('/profile/edit')}}">
					<button class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit My Profile</button>
				</form>
			@endif
		</div>
	</div>

	<div id="profile_body_left">
		<h2>Recipes({{$recipes->count()}})</h2>

		@if($recipes->count()==0)
			No Recipe Found
		@else
			@foreach ($recipes as $recipe)
				@php
					$likes = App\Likes::where('recipeID', $recipe->recipeID)->count();
				@endphp
				<div id="profile_recipe">
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
		@endif
	</div>

	<div id="profile_body_right">
		<h2>Profile Info</h2>
		<table>
			<tr>
				<td>Name</td>
				<td>:</td>
				<td>{{$user->userName}}</td>
			</tr>

			<tr>
				<td>Gender</td>
				<td>:</td>
				<td>@if($user->userGender=="M")
						Male
					@else
						Female
					@endif</td>
			</tr>

			<tr>
				<td>Email</td>
				<td>:</td>
				<td>{{$user->user_auth['userEmail']}}</td>
			</tr>

			<tr>
				<td>Member Since</td>
				<td>:</td>
				<td>{{date('d M Y', strtotime($user->userDateCreated))}}</td>
			</tr>
		</table>

		<div id="profile_following">
			<span class="profile_judul"><a href="{{url('/user/' . $user->userUsername . '/following')}}">Following ({{$followingCount}})</a>:</span>

			@if($followingCount==0)
				This User has No Following
			@else
				@foreach ($following as $friend)
					<div id="friends">
						<div id="friends_img">
							<img src="{{asset('/profile/' . $friend->dest_info['userProfileURL'])}}">
						</div>
						<div id="friends_name">
							<a href="{{url('/user/' . $friend->dest_info['userUsername'])}}" style="color:black;">
							{{$friend->dest_info['userName']}}
							</a>
						</div>
					</div>
				@endforeach
			@endif
		</div>

		<div id="profile_followers">
			<span class="profile_judul"><a href="{{url('/user/' . $user->userUsername . '/followers')}}">Followers ({{$followersCount}})</a>:</span>

			@if($followersCount==0)
				This User has No Followers
			@else
				@foreach ($followers as $friend)
					<div id="friends">
						<div id="friends_img">
							<img src="{{asset('/profile/' . $friend->source_info['userProfileURL'])}}">
						</div>
						<div id="friends_name">
							<a href="{{url('/user/' . $friend->source_info['userUsername'])}}" style="color:black;">
							{{$friend->source_info['userName']}}
							</a>
						</div>
					</div>
				@endforeach
			@endif
		</div>
	</div>
</div>

	
@endsection