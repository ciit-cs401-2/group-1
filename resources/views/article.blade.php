<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>
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
    <!--========== NAVIGATION BAR ==========-->
            <div class="header2">
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

                        <p>123</p>
                    </div>
                    <div class = "numbers">
                        <img width="24" height="24" src="https://img.icons8.com/material-sharp/100/6f4e37/speech-bubble--v1.png" alt="speech-bubble--v1"/>
                        <p>122342343</p>
                    </div>
                    <div class = "numbers">
                        <img width="24" height="24" src="https://img.icons8.com/external-solid-style-bomsymbols-/24/6f4e37/external-design-web-design-device-solid-style-set-2-solid-style-bomsymbols-.png" alt="external-design-web-design-device-solid-style-set-2-solid-style-bomsymbols-"/>
                
                        <p>122342343</p>
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
                        <span class="tag">{{ $tag->tag_name }}</span>
                    @endforeach
                </div>
            </div>
            <p class = "content">{{ $post->content }}</p>
            <div class = "comments">
                <h3>Comments</h3>
                <form class="inputComment">
                    <textarea class="commentBox" placeholder="Share your thoughts!" name="content" required></textarea>
                    <div class="buttonWrapper">
                        <button type="button" class="commentButton">Enter</button>
                    </div>
                </form>

                <div>
                    <div class = "comment">
                        <div class = "user">
                            <img width="48" height="48" src="https://img.icons8.com/fluency-systems-filled/48/6f4e37/user-male-circle.png" alt="user-male-circle"/>
                            <div class= "userDetails">
                                <p class = "commentAuthor">Dana Alania</p>
                                <p class = "commentDate">August 7, 2024</p>
                            </div>
                        </div>
                        <p class = "commentContent">Wow, nice!</p>
                        
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
</body>
</html>