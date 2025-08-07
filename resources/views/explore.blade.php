<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coffee & Contemplation | Explore</title>
    <link rel="icon" href="\storage\images\icons8-coffee-beans-100.png">
    @vite('resources/css/explore.css')
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Libre+Franklin:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    @if (session('access_denied'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                plsLogin()
            });
        </script>
    @endif

    @if ($errors->has('email'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                incorrectCred();
            });
        </script>
    @endif

    <div id="plslogin">
            <h1>Please Log In</h1>
            <p>Please log in to access user dashboard</p>
            <button class="incbutton" onclick="closePls()">OK</button>
        </div>
    <div id="incorrect">
        <h1>Incorrect Credentials</h1>
        <p>Either your email address, password, or both are incorrect</p>
        <p>Please try again with the correct credentials.</p>
        <button class="incbutton" onclick="closeIncorrect()">OK</button>
    </div>
    <div id="overlay2"></div>
    <div class="form" id="login">
        <form action="{{ route('login') }}" method="POST" class="form-container">
            @csrf
            <h1>Log In</h1>
            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter email address" name="email" required></input>
            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter password" name="password" required></input>

            <button type="submit" class="button" onclick="">Log In</button>
            <button type="button" class="button cancel" onclick="closeFormLogIn()">Cancel</button>
            <p onclick="window.location='{{ url('register') }}'">Create an Account</p>
        </form>
    </div>
    <div id="overlay"></div>
    <script>
        function logIn() {
            alert("You have logged in succesfully!");
            document.getElementById("login").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }

        function openFormLogIn() {
            document.getElementById("login").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }

        function closeFormLogIn() {
            document.getElementById("login").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }
        function incorrectCred() {
            document.getElementById("incorrect").style.display = "block";
            document.getElementById("overlay2").style.display = "block";
        }

        function closeIncorrect() {
            document.getElementById("incorrect").style.display = "none";
            document.getElementById("overlay2").style.display = "none";
        }

        function plsLogin() {
            document.getElementById("plslogin").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }

        function closePls() {
            document.getElementById("plslogin").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }

    </script>
    <div class="hero">
        <div class="nav">
            <div class="logo">
                <img src="\storage\images\icons8-coffee-beans-100.png"></img>
                <h1>Coffee & Contemplation</h1>
            </div>
            <div class="ulcon">
                <ul class="ul-nav">
                    <li>
                        <a class="li-a" href="{{ route('explore') }}">EXPLORE</a>
                    </li>
                    <li>
                        <a class="li-a" href="{{ route('home')}}">HOME</a>
                    </li>
                    <li>
                        <a class="li-a" href="{{ route('newdashboard')}}">DASHBOARD</a>
                    </li>
                </ul>
            </div>
            <div class="containbutton">
                @if(Auth::check())
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="login">Logout</button>
                </form>
                @else
                    <button class="login" onclick="openFormLogIn()">Login</button>
                @endif
            </div>
        </div>
    </div>
<div class="searchsec">
    <div class="search">
        <form action="{{ route('explore') }}" method="GET" style="display: flex; width: 100%;">
            <input
                type="text"
                name="query"
                class="searchTerm"
                placeholder="Looking for a post?"
                value="{{ request('query') }}"
            >
            <button type="submit" class="searchButton">
                <i class="fa fa-search"></i>
            </button>
        </form>
    </div>
</div>
    <div class="main">
        @if ($posts->isEmpty()) <div class="rightcol"><h1>No posts found</h1></div> @endif
        @if ($featured_post)
            <div class="leftcol">
                <div class="image-container">
                    <img src="{{ $featured_post->image_data ? route('posts.image', $featured_post->id) : asset('/storage/images/pexels-chevanon-302901.jpg')}}">
                </div>
            </div>
            <div class="rightcol">
                <p class="tags">
                    @foreach($featured_post->tags as $tag)
                        #{{ strtoupper($tag->tag_name) }}
                    @endforeach
                </p>
                <a class="title" href="{{ route('article.show', ['id' => $featured_post->id]) }}">
                    <h1>{{$featured_post->title}}</h1>
                </a>
                <p class="description">{{$featured_post->content}}</p>
                <p class="info">
                    {{ strtoupper(optional($featured_post->published_date)->format('F d Y')) }} |
                    BY {{ strtoupper($featured_post->contributors->first()->name ?? 'UNKNOWN') }}
                </p>
                <button class="readmore">Read Article</button>
            </div>
        @endif
    </div>
    <div class="featuredsec">
    @if ($posts->isNotEmpty())
        <h1>More Posts</h1>
        @foreach($posts->chunk(3) as $group)
            <div class="card-container">
                @foreach($group as $post)
                    <a href="{{ route('article.show', ['id' => $post->id]) }}" class="card-link">
                        <div class="card">
                            <div class="image-container">
                                <img src="{{ $post->image_data ? route('posts.image', $post->id) : asset('storage/images/default.jpg') }}">
                            </div>
                            <div class="card-content">
                                <p class="tags">
                                    @foreach($post->tags as $tag)
                                        #{{ strtoupper($tag->tag_name) }}
                                    @endforeach
                                </p>
                                <h3>{{ $post->title }}</h3>
                                <p class="info">
                                    {{ strtoupper(optional($post->published_date)->format('F d Y')) }} |
                                    BY {{ strtoupper($post->contributors->first()->name ?? 'UNKNOWN') }}
                                </p>
                                <p class="info">
                                    <img width="24" height="24" src="https://img.icons8.com/fluency-systems-filled/24/6f4e37/facebook-like.png" alt="facebook-like"/> {{ strtoupper($post->analytics->likes ?? 0) }} |
                                    <img width="12" height="12" src="https://img.icons8.com/material-sharp/100/6f4e37/speech-bubble--v1.png" alt="speech-bubble--v1"/> {{ strtoupper($post->analytics->comments ?? 0) }} |
                                    <img width="24" height="24" src="https://img.icons8.com/external-solid-style-bomsymbols-/24/6f4e37/external-design-web-design-device-solid-style-set-2-solid-style-bomsymbols-.png" alt="external-design-web-design-device-solid-style-set-2-solid-style-bomsymbols-"/> {{ strtoupper($post->analytics->views ?? 0) }} |
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endforeach
        @endif
    </div>
    <div class="footer">
        <img src="\storage\images\icons8-coffee-beans-100.png" style="width: 48px;"></img>
        <h5>Coffee & Contemplation</h5>
        <h6>COPYRIGHT © 2025</h6>
        <h6><a target="_blank" href="https://icons8.com/icon/oZJK8H59OkPG/coffee-bean">Coffee Bean</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a></h6>
    </div>
</body>
</html>
