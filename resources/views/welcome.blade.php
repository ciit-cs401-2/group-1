<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    {{--@if (Auth::check())
        <p>Logged in as {{ Auth::user()->name }} ({{ Auth::user()->name }})</p>
    @else
        <p>Not logged in</p>
    @endif (This is just for debugging, can confirm that you're logged in as whoever)--}}

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Coffee & Contemplation</title>
        <link rel="icon" href="\storage\images\icons8-coffee-beans-100.png">
        @vite('resources/css/landing.css')
        @vite('/resources/css/app.css')
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
            <div class="header">
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
            <h1 class="quote">"Coffee is always a good idea." </h1>
            <button class="explore" onclick="window.location='{{ url('explore') }}'">EXPLORE</button>
        </div>
        <div class="featuredsec">
            <h1>FEATURED POSTS</h1>
            <div class="card-container">
                @forelse($posts as $post)
                    <a href="{{route('article.show', $post->id)}}">
                        <div class="card">
                            @if($post->image_data)
                                <img src="{{ route('posts.image', $post->id) }}" alt="Post Image" style="width: 100%; height: auto;">
                            @else
                                <img src="{{ $post->image_data ? route('posts.image', $post->id) : asset('storage/images/default.jpg') }}" alt="Placeholder">
                            @endif

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
                @empty
                    <p>No featured posts available.</p>
                @endforelse
            </div>
        </div>
        <div class="cardsec" id="about">
            <p class="subheading">A hub for all coffee lovers</p>
            <h1>Join the Community</h1>
            <div class="card-container2">
                <div class="card2">
                    <div class="partition">
                        <h2>Share Your Thoughts</h2>
                    </div>
                    <div class="partition">
                        <p class="body">Spill the beans about anything coffee today! Got any thoughts brewing? Share your thoughts with us!</p>
                    </div>
                </div>
                <div class="card2">
                    <div class="partition">
                        <h2>Discuss with Coffee Lovers</h2>
                    </div>
                    <div class="partition">
                        <p class="body">Talk with fellow coffee coffee lovers about anything coffee anywhere anytime!</p>
                    </div>
                </div>
                <div class="card2">
                    <div class="partition">
                        <h2>Discover New Things</h2>
                    </div>
                    <div class="partition">
                        <p class="body">Learn new things about coffee and explore new ideas! Discover new facts from your fellow coffee lovers and share your own!</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="cta">
            <div class="ctacol">
                <img src="/storage/images/pexels-chevanon-302901.jpg">
            </div>
            <div class="ctacol">
                <h3>Never miss a post</h3>
                <p class="more">Sign up for an account today to post and discuss about all things coffee! Start blogging and sharing on Coffee & Contemplations today.</p>
                <button class="signup" onclick="window.location='{{ url("register") }}'">Sign Up</button>
            </div>
        </div>
        <div class="footer">
            <img src="\storage\images\icons8-coffee-beans-100.png" style="width: 48px"></img>
            <h5>Coffee & Contemplation</h5>
            <h6>COPYRIGHT © 2025</h6>
            <h6><a target="_blank" href="https://icons8.com/icon/oZJK8H59OkPG/coffee-bean">Coffee Bean</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a></h6>
        </div>
    </body>
</html>
