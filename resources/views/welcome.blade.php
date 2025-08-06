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
        <title>insert blog name here</title>
        <link rel="icon" href="\storage\images\icons8-coffee-beans-100.png">
        @vite('resources/css/landing.css')
        @vite('/resources/css/app.css')
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Libre+Franklin:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>
    <body>
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

                <button type="submit" class="button" onclick="incorrectCred()">Log In</button>
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

        </script>
        <div class="hero">
            <div class="header">
                <div class="nav">
                    <div class="logo">
                        <img src="\storage\images\icons8-coffee-beans-100.png"></img>
                        <h1>Blog Title</h1>
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
                        <button class="login" onclick="openFormLogIn()">Log In</button>
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
                                👍 {{ strtoupper($post->analytics->likes ?? 0) }} |
                                💭 {{ strtoupper($post->analytics->comments ?? 0) }} |
                                👁‍🗨 {{ strtoupper($post->analytics->views ?? 0) }} |
                            </p>
                        </div>
                    </div>
                @empty
                    <p>No featured posts available.</p>
                @endforelse
            </div>
        </div>
        <!--<div class="featuredsec">
            <h1>FEATURED POSTS</h1>
            <div class="card-container">
                <div class="card">
                    <img src="https://picsum.photos/id/237/500/400">
                    <div class="card-content">
                        <p class="tags">#COFFEE #TAGS #HERE</p>
                        <h3>Article Title</h3>
                        <p class="info"> JULY 19 2025 | BY JULIANA JIMENO</p>
                    </div>
                </div>
                <div class="card">
                    <img src="https://picsum.photos/id/237/500/400">
                    <div class="card-content">
                        <p class="tags">#COFFEE #TAGS #HERE</p>
                        <h3>Article Title</h3>
                        <p class="info"> JULY 19 2025 | BY JULIANA JIMENO</p>
                    </div>
                </div>
                <div class="card">
                    <img src="https://picsum.photos/id/237/500/400">
                    <div class="card-content">
                        <p class="tags">#COFFEE #TAGS #HERE</p>
                        <h3>Article Title</h3>
                        <p class="info"> JULY 19 2025 | BY JULIANA JIMENO</p>
                    </div>
                </div>
            </div>
        </div>-->
        <div class="cardsec" id="about">
            <p class="subheading">A hub for all coffee lovers</p>
            <h1>Join the Community</h1>
            <div class="card-container2">
                <div class="card2">
                    <div class="partition">
                        <h2>Share Your Thoughts</h2>
                    </div>
                    <div class="partition">
                        <p class="body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
                <div class="card2">
                    <div class="partition">
                        <h2>Discuss with Coffee Lovers</h2>
                    </div>
                    <div class="partition">
                        <p class="body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
                <div class="card2">
                    <div class="partition">
                        <h2>Discover New Things</h2>
                    </div>
                    <div class="partition">
                        <p class="body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="cta">
            <div class="ctacol">
                <img src="https://picsum.photos/id/237/500/200">
            </div>
            <div class="ctacol">
                <h3>Never miss a post</h3>
                <p class="more">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <button class="signup" onclick="window.location='{{ url("register") }}'">Sign Up</button>
            </div>
        </div>
        <div class="footer">
            <img src="\storage\images\icons8-coffee-beans-100.png" style="width: 48px"></img>
            <h5>Blog Title</h5>
            <h6>COPYRIGHT © 2025</h6>
            <h6><a target="_blank" href="https://icons8.com/icon/oZJK8H59OkPG/coffee-bean">Coffee Bean</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a></h6>
        </div>
    </body>
</html>
