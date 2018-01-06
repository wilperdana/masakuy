@extends('layout.app')

@section('main-app')
@foreach ($recipe as $r)
	@php 
		$img = $r->recipeImageURL;
		$name = $r->recipeName;
		$desc = $r->recipeDescription;
		$user_name = $r->user_info['userName'];
		$userUsername = $r->user_info['userUsername'];
		$id = $r->recipeID;
		$userID = $r->userID;
		$custURL = $r->recipeCustomURL;
	@endphp
@endforeach
<div id="recipe_cont">
	<div id="recipe_head">
		<div class="recipe_img" style="background:url({{url('recipes/' . $img)}}) no-repeat center; background-size:cover;"></div>
		<div class="recipe_box merah_bg">
			<span class="recipe_title bold">
				{{$name}}
			</span>
			<span class="recipe_info">Cooked by: <a href="{{url('/user/' . $userUsername)}}" style="color:white;">{{$user_name}}</a>
				
			</span>
			<span class="recipe_loves">
				<img src="{{url('img/love.png')}}" class="img_love"> {{$totalLikes}} | <img src="{{url('img/eye.png')}}" class="img_love"> {{$recipeViews}}
			</span>

			<div class="recipe_btn_box">
				@if(Session::has('userActive'))
					@if($statusLikes==0)
						<form action="{{url('/doLike/' . $id)}}" method="get" style="display:inline;">
							<button class="btn btn-primary"><i class="fa fa-heart"></i> Like Recipe</button>
						</form>
					@else
						<form action="{{url('/doUnlike/' . $id)}}" method="get" style="display:inline;">
							<button class="btn btn-danger"><i class="fa fa-heart"></i> Unlike Recipe</button>
						</form>
					@endif

				@if($userID==Session::get('userActive'))
				<form method="get" action="{{url('/recipe/' . $custURL . '/edit')}}" style="display:inline;">
					<button class="btn btn-success"><i class="fa fa-pencil"></i> Edit Recipe</button>
				</form>
				@endif
				@else
				<button class="btn btn-disabled" disabled><i class="fa fa-love"></i>Like Recipe</button> <br>
				<small class="white"><a href="/login">Log in or Register</a> to Like the Recipe</small>
				@endif
			</div>

		</div>
	</div>

	<div id="recipe_body">
		{!!$desc!!}
	</div>

	<div id="recipe_comments">
		<h2><i class="fa fa-comment"></i> Comments ({{$totalComments}})</h2>
		@if(Session::has('userActive'))
		<form method="post" action="{{url('/addComment/' . $id)}}">
			<div class="form-group">
				<label>Add New Comment:</label>
				<textarea name="comment" class="form-control" rows="3"></textarea>
				<button class="btn btn-primary btn-sm">Post New Comment</button>
				@if ($errors->any())
				<small class="merah">Comment is required</small>
				@endif
			</div>
		</form>
		@else
		<span><a href="{{url('/login')}}">Log in or Register</a> to Comment</span><br><br>
		@endif

		@foreach($comments as $comment)
		<div id="comments">
			<div class="comment_photo">
				<img src="{{asset('/profile/' . $comment->user_info['userProfileURL'])}}">
			</div>
			<div class="comment_content">
				<span class="comment_name"><a href="{{url('/user/'.$comment->user_info['userUsername'])}}">{{$comment->user_info['userName']}}</a></span>
				<span class="the_comment">	
					{{$comment->commentFill}}
				</span>
				@if($comment->userID==Session::get('userActive'))
				<span class="comment_opt">
					<a href="{{url('/comment/delete/' . $comment->commentID) . '/' . $id}}">Delete Comment</a>
				</span>
				@endif
			</div>
		</div>
		@endforeach
	</div>
</div>
@endsection