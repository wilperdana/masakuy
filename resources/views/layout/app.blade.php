<!DOCTYPE html>
<html>
    <head>
        <title>masakuy.com | Your cooking guider</title>

        <link href="https://fonts.googleapis.com/css?family=News+Cycle" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="{{url('css/global.css')}}">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script type="text/javascript" src="{{url('js/global.js')}}"></script>
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="icon" type="image/png" href="{{url('/img/favicon.png')}}" />

    </head>
    <body>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#navbar_collapse").hide();
            });
        </script>

        <div id="header">
            <div id="container">
                <div id="navbar_left">
                    <a href="{{url('/')}}"><img src="{{asset('/img/logo.png')}}"></a>
                </div>
                @if (Session::has('userActive'))
                @php
                    $username = App\User::where('userID', Session::get('userActive'))->get()->first()->userName;
                    $userUsername = App\User::where('userID', Session::get('userActive'))->get()->first()->userUsername;
                @endphp
                <div id="navbar_right">
                    <div id="navbar_name">
                        {{$username}}
                        <i class="fa fa-caret-down"></i>
                        <div id="navbar_collapse">
                            <li><i class="fa fa-user"></i> <a href="{{url('/user/' . $userUsername)}}">View My Profile</a></li>
                            <li><i class="fa fa-sign-out"></i> <a href="/logout">Logout</a></li>
                        </div>
                    </div>
                    <div id="navbar_compose">
                        <i class="fa fa-pencil-square-o"></i> New Recipe
                    </div>
                    <div id="navbar_feeds">
                        <i class="fa fa-rss"></i> Feeds
                    </div>
                </div>
                @else
                <div id="navbar_right">
                    <div id="navbar_login">
                        <i class="fa fa-sign-in"></i> Login / Register
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div id="main-section">
            <div id="container">
                @yield('main-app')
            </div>
        </div>

    
    </body>

    <script type="text/javascript">
        $("#navbar_compose").click(function() {
            window.location.href = "{{URL::to('/recipes/new')}}"
        });

        $("#navbar_login").click(function() {
            window.location.href = "{{URL::to('/login')}}"
        });

        $("#navbar_feeds").click(function() {
            window.location.href = "{{URL::to('/feeds')}}"
        });

        $("#navbar_name").click(function() {
            $("#navbar_collapse").toggle();
        });
    </script>
</html>
