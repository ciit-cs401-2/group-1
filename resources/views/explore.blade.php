<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog | Explore</title>
    <link rel="icon" href="\storage\images\icons8-coffee-beans-100.png">
    @vite('resources/css/explore.css')
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <div class="nav">
            <div class="logo">
                <img src="\storage\images\icons8-coffee-beans-100.png"></img>
                <h1>Blog Title</h1>
            </div>
            <div class="ulcon">
                <ul class="ul-nav">
                    <li>
                        <a class="li-a" href="#about">ABOUT</a>
                    </li>
                    <li>
                        <a class="li-a" href="#">HOME</a>
                    </li>
                    <li>
                        <a class="li-a" href="#">CONTACT</a>
                    </li>
                </ul>
            </div>
            <div class="containbutton">
                <button class="login" onclick="openFormLogIn()">Log In</button>
            </div>
        </div>
    </div>
    <div class="searchsec">
        <div class="search">
            <input type="text" class="searchTerm" placeholder="Looking for a post?">
            <button type="submit" class="searchButton">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
    <div class="main">
        <div class="leftcol">
            <img src="{{ $featured_post->image_data ? route('posts.image', $featured_post->id) : asset('/storage/images/pexels-chevanon-302901.jpg')}}">
        </div>
        <div class="rightcol">
            <p class="tags">
                @foreach($featured_post->tags as $tag)
                    #{{ strtoupper($tag->tag_name) }}
                @endforeach
            </p>
            <h1 class="title">{{$featured_post->title}}</h1>
            <p class="description">{{$featured_post->content}}</p>
            <p class="info">
                {{ strtoupper(optional($featured_post->published_date)->format('F d Y')) }} |
                BY {{ strtoupper($featured_post->contributors->first()->name ?? 'UNKNOWN') }}
            </p>
            <button class="readmore">Read Article</button>
        </div>
    </div>
    <div class="featuredsec">
        <h1>More Posts</h1>
        @foreach($posts->chunk(3) as $group)
                <div class="card-container">
                    @foreach($group as $post)
                        <div class="card">
                            <img src="{{ $post->image_data ? route('posts.image', $post->id) : asset('storage/images/default.jpg') }}">
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
                    @endforeach
                </div>
        @endforeach
    </div>
    <div class="footer">
        <img src="\storage\images\icons8-coffee-beans-100.png" style="width: 48px;"></img>
        <h5>Blog Title</h5>
        <h6>COPYRIGHT © 2025</h6>
        <h6><a target="_blank" href="https://icons8.com/icon/oZJK8H59OkPG/coffee-bean">Coffee Bean</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a></h6>
    </div>
</body>
</html>
