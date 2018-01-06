@extends('layout.app')

@section('main-app')
<div id="recipe_box">
	<h2>Edit Recipe: {{$recipe->recipeName}}</h2>
	<form enctype="multipart/form-data" method="post" action="{{url('/recipe/doEdit/' . $recipe->recipeID)}}">
		{{csrf_field()}}
	<div class="form-group">
		<label>Recipe Name</label>
		<input type="text" name="recipeName" class="form-control" value="{{$recipe->recipeName}}">
		@if($errors->has('recipeName'))
		<span class="alert text-danger">Recipe Name is Required !</span>
		@endif
	</div>

	<div class="form-group">
		<label>Recipe Featured Image</label>
		<input type="file" name="recipeImage" class="form-control">
		<small>If You Don't want to change recipe image, leave this.</small>
	</div>

	<div class="form-group">
		<label>Recipe Description</label>
		<textarea name="recipeDesc" id="desc" class="form-control">{{$recipe->recipeDescription}}</textarea>
		<script type="text/javascript">
			$("#desc").ckeditor();
		</script>
		@if($errors->has('recipeDesc'))
		<span class="alert text-danger">Recipe Description is Required !</span>
		@endif
	</div>

	<button class="btn btn-success">Save Changes</button>
	</form>
</div>
@endsection