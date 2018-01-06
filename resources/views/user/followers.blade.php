@extends('layout.app')

@section('main-app')
	<div id="profile_head">
		<div id="profileimg">
			<img src="{{asset('/profile/' . $userInfo->userProfileURL)}}">
		</div>

		<div id="profileinfo">
			<div id="profilename">{{$userInfo->userName}}</div>
			<div id="profilebio">{{$userInfo->userBio}}</div>
			@if(Session::has('userActive'))
			@if(Session::get('userActive')!=$userInfo->userID)
			@if(App\Friends::where([ ['friendSource', '=', Session::get('userActive')], ['friendDest', '=', $userInfo->userID] ])->count())
				<form method="get" action="{{url('/user/unfollow/' . $userInfo->userID)}}">
					<button class="btn btn-danger btn-sm"><i class="fa fa-minus"></i> Unfollow</button>
				</form>
			@else
				<form method="get" action="{{url('/user/follow/' . $userInfo->userID)}}">
					<button class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Follow</button>
				</form>
			@endif
			@endif
			@endif

			@if(Session::get('userActive')==$userInfo->userID)
				<form method="get" action="{{url('/profile/edit')}}">
					<button class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit My Profile</button>
				</form>
			@endif
		</div>
	</div>

	<div id="profile_body_left" style="width: 100%;">
		<h2>Followers:</h2>
		@if($followers->count()==0)
			This User Has No Followers
		@endif

		@foreach ($followers as $users)
		@php
			$followingCount = App\Friends::where('friendSource', $users->source_info['userID'])->count();
		 	$followersCount = App\Friends::where('friendDest', $users->source_info['userID'])->count();
		@endphp
		<div id="profile_recipe" style="background: white;">
			<div id="profile_recipe_img">
				<img src="{{asset('/profile/' . $users->source_info['userProfileURL'])}}" style="width:100px; float: left;">
			</div>

			<div id="profile_recipe_info" style="margin-left:-35px;">
				<span class="profile_recipe_name" style="margin-bottom:-20px;"><a href="{{url('/user/' . $users->source_info['userUsername'])}}">{{$users->source_info['userName']}}</a></span> <br>
				<span class="profile_recipe_stats">
					Following : {{$followingCount}}<br>
					Followers : {{$followersCount}}<br>
					Member Since : {{date('d M Y', strtotime($users->source_info['userDateCreated']))}}<br>
				</span>
			</div>
		</div>
		@endforeach
	</div>

	
@endsection