<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $post->title }}</title>
    <link rel="icon" href="\storage\images\icons8-coffee-beans-100.png">
    <link href="/resources/css/app.css" rel="stylesheet">
    @vite('resources/css/article.css')
    @vite('/resources/css/app.css')


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Domine:wght@400..700&display=swap" rel="stylesheet">
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
    <!--========== NAVIGATION BAR ==========-->
            <div class="header2">
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

    <!--========== ARTICLE IMAGE CONTAINER ==========-->
    <div class = "container">
        <div class = "article">
            <h1>{{ $post->title }}</h1>
            <div class = "details">
                <p class = "author">
                    by {{ $post->contributors->first()->name ?? 'Unknown' }}
                </p>
                <p class = "date">
                    Last edited on {{ $post->updated_at->format('F j, Y') }}
                </p>
            </div>
            <div class = "containerImg">
                <img class="postImg" src="{{ route('posts.image', ['id' => $post->id]) }}" alt="Post Image">
            </div>
            <div class = tagsContainer>
                <div class = "analytics">
                    <div class = "numbers">
                        <img id="likeIcon" width="24" height="24" src="https://img.icons8.com/fluency-systems-regular/24/6f4e37/facebook-like.png"  alt="facebook-like" class="w-6 h-6 cursor-pointer transition-all duration-200"/>

                        <p> {{$post->analytics['likes']}}</p>
                    </div>
                    <div class = "numbers">
                        <img width="24" height="24" src="https://img.icons8.com/material-sharp/100/6f4e37/speech-bubble--v1.png" alt="speech-bubble--v1"/>
                        <p>{{$post->analytics['comments']}}</p>
                    </div>
                    <div class = "numbers">
                        <img width="24" height="24" src="https://img.icons8.com/external-solid-style-bomsymbols-/24/6f4e37/external-design-web-design-device-solid-style-set-2-solid-style-bomsymbols-.png" alt="external-design-web-design-device-solid-style-set-2-solid-style-bomsymbols-"/>
                
                        <p>{{$post->analytics['views']}}</p>
                    </div>
                    <script>
                        const likeIcon = document.getElementById('likeIcon');
                        let liked = false;

                        likeIcon.addEventListener('click', () => {
                            liked = !liked;
                            likeIcon.src = liked 
                            ? 'https://img.icons8.com/fluency-systems-filled/24/6f4e37/facebook-like.png' 
                            : 'https://img.icons8.com/fluency-systems-regular/24/6f4e37/facebook-like.png'; 
                        });
                    </script>
                </div>
                <div class="tags">
                    @foreach ($post->tags as $tag)
                        <span class="tag">#{{ $tag->tag_name }} &nbsp;</span>
                    @endforeach
                </div>
            </div>
            <p class = "content">{{ $post->content }}</p>
            <div class = "comments">
                <h3>Comments</h3>
                <form class="inputComment" action="{{route('comment.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <textarea class="commentBox" placeholder="Share your thoughts!" name="content" required></textarea>
                    <div class="buttonWrapper">
                        <button type="submit" class="commentButton">Enter</button>
                    </div>
                </form>

                <div>
                    <div class="commentCardContainer">
                        @forelse ($post->comments as $comment)
                            <div class = "commentCard">
                                <div class="otherImgContainer">
                                    <img class="profileImage" src="{{asset('storage/images/defaultGuy.jpg')}}" alt="User">
                                </div>
                                <div class="otherContentContainer">
                                    <p><span class="userHandle">{{$comment->user->name}}</span></p>
                                    <p class="commentContent">
                                        {{trim($comment->content)}}
                                    </p>
                                    <p class ="details"> Last edited on {{ $comment->updated_at->format('F j, Y') }}</p>
                                </div>
                            </div>    
                        @empty
                            <h3>No comments</h3>
                        @endforelse
                    </div>      
                </div>
            </div>
        </div>
        <div class = "others">
            <h3>Other Posts</h3>
            @foreach ($otherPosts as $other)
                <div class="other card">
                    <div class="otherImgContainer">
                        <img class="img1" src="{{ route('posts.image', ['id' => $other->id]) }}" alt="Post Image">
                    </div>
                    <div class="otherContentContainer">
                        <a href="{{ route('article.show', $other->id) }}" class="otherTitle">
                            {{ $other->title }}
                        </a>
                        <p class="otherAuthor">
                            by {{ $other->contributors->first()->name ?? 'Unknown' }}
                        </p>
                    </div>
                </div>
                <hr class="line">
            @endforeach
        </div>
    </div>
    <div class="footer">
        <img src="\storage\images\icons8-coffee-beans-100.png" style="width: 48px;"></img>
        <h5>Coffee & Contemplation</h5>
        <h6>COPYRIGHT © 2025</h6>
        <h6><a target="_blank" href="https://icons8.com/icon/oZJK8H59OkPG/coffee-bean">Coffee Bean</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a></h6>
    </div>
</body>
</html>