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
            <div class="tags">
                @foreach ($post->tags as $tag)
                    <span class="tag">{{ $tag->tag_name }}</span>
                @endforeach
            </div>
            <p class = "content">{{ $post->content }}</p>
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
