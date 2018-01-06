<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\User;
use App\UserAuth;
use App\Recipe;
use App\Friends;
use Session;
use Redirect;
use Hash;
use Carbon\Carbon;

class PageController extends Controller
{
    public function home() {
        $recipe = Recipe::inRandomOrder()->limit(3)->get();
        
        return view('index')->with([
            'recipes' => $recipe
        ]);
    }

    public function login() {
        return view('login');
    }

    public function doRegister(Request $req) {
        $rules = [
            'email' => 'required|email|unique:m_users_auth,userEmail',
            'password' => 'confirmed'
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }

        Session::flush();
        Session::set('email', $req['email']);
        Session::set('password', $req['password']);

        return redirect('/register');

    }

    public function registerStep2(Request $req) {
        $rules = [
            'nama' => 'required',
            'custom_profile' => 'required|unique:m_users,userUsername',
            'dob' => 'required',
            'gender' => 'required'
        ];

        $validator = Validator::make($req->all(), $rules);

        Session::set('nama', $req['nama']);
        Session::set('dob', $req['dob']);
        Session::set('custom_profile', $req['custom_profile']);
        Session::set('gender', $req['gender']);

        if ($validator->fails()) {
            if ($validator->errors()->has('nama')) {
                Session::set('error_nama', true);
            } else {
                Session::forget('error_nama');
            }

            if ($validator->errors()->has('custom_profile')) {
                Session::set('error_cp', true);
            } else {
                Session::forget('error_cp');
            }

            if ($validator->errors()->has('dob')) {
                Session::set('error_dob', true);
            } else {
                Session::forget('error_dob');
            }

            if ($validator->errors()->has('gender')) {
                Session::set('error_gender', true);
            } else {
                Session::forget('error_gender');
            }

            return redirect('/register');
        }

        if ($req->file('imgProfile')==null)
            Session::set('imgProfile', 'no-profile.svg');
        else {
            $fileName = $req->file('imgProfile')->getClientOriginalName();
            $req->file('imgProfile')->move('profile/', $fileName);
            Session::set('imgProfile', $fileName);
        }

        return redirect('/register/step2');
    }

    public function finishRegister(Request $req) {
        $user = new User();
        $user['userName'] = Session::get('nama');
        $user['userGender'] = Session::get('gender');
        $user['userUsername'] = Session::get('custom_profile');
        $user['userDOB'] = Session::get('dob');
        $user['userBio'] = $req['bio'];
        $user['userDateCreated'] = Carbon::now()->timezone('Asia/Jakarta')->toDateTimeString();
        $user['userProfileURL'] = Session::get('imgProfile');
        $user->save();

        $userAuth = new UserAuth();
        $userID = User::where('userUsername', Session::get('custom_profile'))->get()->first()->userID;
        $userAuth['userID'] = $userID;
        $userAuth['userEmail'] = Session::get('email');
        $userAuth['userPassword'] = bcrypt(Session::get('password'));
        $userAuth->save();

        Session::flush();
        Session::set('userActive', $userID);

        return redirect('/register/finish');
    }

    public function doLogin(Request $req) {
        $user = UserAuth::where('userEmail', $req->emailLogin);

        if ($user->count()) {
            if (Hash::check($req->passwordLogin, $user->get()->first()->userPassword)) {
                $userID = $user->get()->first()->userID;
                Session::set('userActive', $userID);
                return redirect('/');
            } else {
                return redirect('/login')->with('statusFail', 'true');
            }
        } else {
                return redirect('/login')->with('statusFail', 'true');
        }
    }

    public function doLogout() {
        Session::flush();
        return redirect('/');
    }

    public function viewProfile($username) {
        $user = User::where('userUsername', $username)->get()->first();

        if (!$user)
            return redirect('/');

        $recipe = Recipe::where('userID', $user->userID)->get();
        $followingCount = Friends::where('friendSource', $user->userID)->count();
        $followersCount = Friends::where('friendDest', $user->userID)->count();
        $following = Friends::where('friendSource', $user->userID)->take(3)->get();
        $followers = Friends::where('friendDest', $user->userID)->take(3)->get();

        return view('user.profile')->with(['user' => $user, 'recipes' => $recipe, 'following' => $following, 'followers' => $followers, 'followingCount' => $followingCount, 'followersCount' => $followersCount]);
    }

    public function doFollow($userID) {
        $friends = new Friends();
        $friends->friendSource = Session::get('userActive');
        $friends->friendDest = $userID;
        $friends->save();

        $user = User::find($userID);
        return redirect('/user/' . $user->userUsername);
    }

    public function doUnfollow($userID) {
        $friend = Friends::where([
            ['friendSource', '=', Session::get('userActive')],
            ['friendDest', '=', $userID]
        ]);

        $friend->delete();
        $user = User::find($userID);
        return redirect('/user/' . $user->userUsername);
    }

    public function searchRecipe(Request $req) {
        $searchCount = Recipe::where('recipeName', 'LIKE', '%' . $req->textSearch . '%')->count();
        $userCount = User::where('userName', 'LIKE', '%' . $req->textSearch . '%')->count();
        $recipes = Recipe::where('recipeName', 'LIKE', '%' . $req->textSearch . '%')->paginate(5);
        $users = User::where('userName', 'LIKE', '%' . $req->textSearch . '%')->paginate(5);

        return view('recipes.search')->with(['recipes' => $recipes, 'query' => $req->textSearch, 'searchCount' => $searchCount, 'users' => $users]);
    }

    public function editProfile() {
        $user = User::find(Session::get('userActive'))->first();

        return view('user.edit')->with(['user' => $user]);
    }

    public function saveProfile(Request $req) {
        $rules = [
            'nama' => 'required',
            'userUsername' => 'required|unique:m_users,userUsername',
            'dob' => 'required',
            'gender' => 'required',
            'bio' => 'required',
            'profileImage' => 'image'
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            if (!(($req->userUsername==User::find(Session::get('userActive'))->first()->userUsername) && $validator->errors()->has('userUsername')))
                return redirect()->back()->withErrors($validator);
        }

        $user = User::find(Session::get('userActive'));
        $user->userName = $req->nama;
        $user->userUsername = $req->userUsername;
        $user->userGender = $req->gender;
        $user->userDOB = $req->dob;
        $user->userBio = $req->bio;

        if ($req->file('profileImage')!=null) {
            $fileName = $req->file('profileImage')->getClientOriginalName();
            $req->file('profileImage')->move('/profile/' . $fileName);
            $user->userProfileURL = $fileName;
        }

        $user->save();

        return redirect('/user/' . $req->userUsername);
    }

    public function showFeeds() {
        $recipes = Recipe::orderBy('recipeID', 'desc')->paginate(10);
        return view('feeds')->with(['recipes' => $recipes]);
    }

    public function showFollowing($username) {
        $user = User::where('userUsername', $username)->get()->first();

        if (!$user)
            return redirect('/');

        $following = Friends::where('friendSource', $user->userID)->paginate(10);
        
        return view('user.following')->with([
            'userInfo' => $user,
            'following' => $following
        ]);
    }

    public function showFollowers($username) {
        $user = User::where('userUsername', $username)->get()->first();

        if (!$user)
            return redirect('/');

        $followers = Friends::where('friendDest', $user->userID)->paginate(10);

        return view('user.followers')->with([
            'userInfo' => $user,
            'followers' => $followers
        ]);
    }
}
