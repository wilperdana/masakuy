<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Recipe;
use App\Likes;
use App\Comments;
use App\User;
use App\Friends;
use Validator;
use Session;

class RecipeController extends Controller
{
    //
    public function viewRecipe($recipename) {
    	$recipe = Recipe::where('recipeCustomURL', $recipename)->get();

    	if ($recipe->isEmpty())
    		return redirect('/');
    	else {
    		$recipeID = Recipe::where('recipeCustomURL', $recipename)->get()->first()->recipeID;
    		$totalLikes = Likes::where('recipeID', $recipeID)->count();
            $totalViews = Recipe::where('recipeID', $recipeID)->get()->first()->recipeViews;
            $comments = Comments::where('recipeID', $recipeID);
            $totalComments = $comments->count();
            $statusLikes = Likes::where([
                ['userID', '=', Session::get('userActive')],
                ['recipeID', '=', $recipeID]
            ])->count();
            Recipe::where('recipeID', $recipeID)->update(['recipeViews' => $totalViews+1]);
    		return view('recipes.view')->with(['recipe' => $recipe, 'totalLikes' => $totalLikes, 'recipeViews' => $totalViews, 'statusLikes' => $statusLikes, 'comments' => $comments->get(), 'totalComments' => $totalComments]);
    	}
    }

    public function createNew() {
        return view('recipes.create');
    }

    public function doCreate(Request $req) {
        $rules = [
            'recipeName' => 'required',
            'recipeImage' => 'required|image',
            'recipeDesc' => 'required'
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->withFailed($validator->failed());
        }

        $customURL = strtolower(str_replace(" ", "-", $req['recipeName']));
        $customURL = strtolower(str_replace("/", "-", $customURL));
        $customURL = strtolower(str_replace("'", "-", $customURL));
        $customURL = strtolower(str_replace("\"", "-", $customURL));
        $customURL = strtolower(str_replace("(", "-", $customURL));
        $customURL = strtolower(str_replace(")", "-", $customURL));

        $counter = Recipe::where('recipeCustomURL', $customURL)->count();

        if ($counter>0) {
            $customURL = $customURL . "-" . ($counter+1);
        }

        $fileName = $req->file('recipeImage')->getClientOriginalName();
        $newFileName = explode(".", $fileName);


        $newRecipe = new Recipe();
        $newRecipe->recipeName = $req['recipeName'];
        $newRecipe->recipeCustomURL = $customURL;
        $newRecipe->userID = Session::get('userActive');
        $newRecipe->recipeDescription = $req['recipeDesc'];
        $newRecipe->recipeImageURL = $customURL . "." . $newFileName[(sizeof($newFileName)-1)];

        $req->file('recipeImage')->move('recipes/', $newRecipe->recipeImageURL);
        $newRecipe->save();


        $username = User::where('userID', Session::get('userActive'))->get()->first()->userUsername;

        return redirect('/recipe/' . $customURL);
    }

    public function doLikeRecipe($recipeID) {
        $likes = new Likes();
        $likes->recipeID = $recipeID;
        $likes->userID = Session::get('userActive');
        $likes->save();

        $recipe = Recipe::find($recipeID);
        $url = '/recipe/' . $recipe->recipeCustomURL;
        return redirect($url);
    }

    public function doUnlikeRecipe($recipeID) {
        $likes = Likes::where([
            ['userID', '=', Session::get('userActive')],
            ['recipeID', '=', $recipeID]
        ]);

        $likes->delete();
        $recipe = Recipe::find($recipeID);
        $url = '/recipe/' . $recipe->recipeCustomURL;
        return redirect($url);
    }

    public function addComment($recipeID, Request $req) {
        $rules = [
            'comment' => 'required'
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $comment = new Comments();
        $comment->recipeID = $recipeID;
        $comment->userID = Session::get('userActive');
        $comment->commentFill = $req->comment;
        $comment->save();

        $recipe = Recipe::find($recipeID);
        $url = '/recipe/' . $recipe->recipeCustomURL;
        return redirect($url);
    }

    public function deleteComment($commentID, $recipeID) {
        $comment = Comments::where('commentID', $commentID);
        $comment->delete();

        $recipe = Recipe::find($recipeID);
        $url = '/recipe/' . $recipe->recipeCustomURL;
        return redirect($url);
    }

    public function editRecipe($recipeCustomURL) {
        $recipe = Recipe::where('recipeCustomURL', $recipeCustomURL)->get()->first();

        return view('recipes.edit')->with(['recipe' => $recipe]);
    }

    public function doEdit(Request $req, $recipeID) {
        $rules = [
            'recipeName' => 'required',
            'recipeImage' => 'image',
            'recipeDesc' => 'required'
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->withFailed($validator->failed());
        }

        $customURL = strtolower(str_replace(" ", "-", $req['recipeName']));
        $customURL = strtolower(str_replace("/", "-", $customURL));
        $customURL = strtolower(str_replace("'", "-", $customURL));
        $customURL = strtolower(str_replace("\"", "-", $customURL));
        $customURL = strtolower(str_replace("(", "-", $customURL));
        $customURL = strtolower(str_replace(")", "-", $customURL));

        $counter = Recipe::where('recipeCustomURL', $customURL)->count();

        if ($counter>0) {
            $customURL = $customURL . "-" . ($counter+1);
        }

        $newRecipe = Recipe::find($recipeID);
        $newRecipe->recipeName = $req['recipeName'];
        $newRecipe->recipeCustomURL = $customURL;
        $newRecipe->userID = Session::get('userActive');
        $newRecipe->recipeDescription = $req['recipeDesc'];

        if ($req->file('recipeImage')!=null) {
            $fileName = $req->file('recipeImage')->getClientOriginalName();
            $newFileName = explode(".", $fileName);
            $newRecipe->recipeImageURL = $customURL . "." . $newFileName[(sizeof($newFileName)-1)];
            $req->file('recipeImage')->move('recipes/', $newRecipe->recipeImageURL);
        }

        $newRecipe->save();

        return redirect('/recipe/' . $customURL);
    }
}
