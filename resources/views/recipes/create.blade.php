@extends('layout.app')

@section('main-app')
<div id="recipe_box">
	<h2>Create New Recipe</h2>
	<form enctype="multipart/form-data" method="post" action="{{url('/recipes/doCreate')}}">
		{{csrf_field()}}
	<div class="form-group">
		<label>Recipe Name</label>
		<input type="text" name="recipeName" class="form-control" value="{{old('recipeName')}}">
		@if($errors->has('recipeName'))
		<span class="alert text-danger">Recipe Name is Required !</span>
		@endif
	</div>

	<div class="form-group">
		<label>Recipe Featured Image</label>
		<input type="file" name="recipeImage" class="form-control">

		@if($errors->has('recipeImage'))
		<span class="alert text-danger">Wrong Image Type !</span>
		@endif
	</div>

	<div class="form-group">
		<label>Recipe Description</label>
		<textarea name="recipeDesc" id="desc" class="form-control">{{old('recipeDesc')}}</textarea>
		<script type="text/javascript">
			$("#desc").ckeditor();
		</script>
		@if($errors->has('recipeDesc'))
		<span class="alert text-danger">Recipe Description is Required !</span>
		@endif
	</div>

	<button class="btn btn-success">Create New Recipe</button>
	</form>
</div>
@endsection