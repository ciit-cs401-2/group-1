<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('/resources/css/app.css')
    @vite('/resources/css/register.css')

    <title>Coffee & Contemplation | Register</title>
    <link rel="icon" href="\storage\images\icons8-coffee-beans-100.png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Libre+Franklin:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="row">
        <div class="left">
            <div class="leftcon1">
                <img src="\storage\images\icons8-coffee-beans-100.png">
                <h1>Coffee &<br>Contemplation</h1>
            </div>
            <div class="leftcon2">
                <h2>Never miss a post</h2>
                <p>Ready to start blogging about all things coffee? Sign up for an account now and join your fellow coffee lovers today.</p>
            </div>
        </div>
        <div class="right">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="formcontainer">
                    <h1>Create an account</h1>
                    <label for="email"><b>Email Address</b></label>
                    <input type="text" placeholder="Enter email address" name="email" required></input>
                    <label for="name"><b>Name</b></label>
                    <input type="text" placeholder="Enter your name here" name="name" required></input>
                    <label for="password"><b>Password</b></label>
                    <input type="password" placeholder="Enter a secure password" name="password" required></input>
                    <label for="cpassword"><b>Confirm Password</b></label>
                    <input type="password" placeholder="Re-enter password" name="password_confirmation" required></input>
                    <div class="center">
                        <button type="submit" class="button" onclick="#">Sign Up</button>
                        <p onclick="window.location='{{ url("/") }}'">Already have an account? Log In</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
