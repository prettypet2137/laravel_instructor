<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            *{-webkit-box-sizing:border-box;box-sizing:border-box}body{padding:0;margin:0}#notfound{position:relative;height:100vh}#notfound .notfound{position:absolute;left:50%;top:50%;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}.notfound{max-width:560px;width:100%;line-height:1.1}.notfound .notfound-404{position:absolute;left:0;top:0;display:inline-block;width:140px;height:140px;background-image:url(../img/emoji.png);background-size:cover}.notfound .notfound-404:before{content:'';position:absolute;width:100%;height:100%;-webkit-transform:scale(2.4);-ms-transform:scale(2.4);transform:scale(2.4);border-radius:50%;background-color:#f2f5f8;z-index:-1}.notfound h1{font-family:nunito,sans-serif;font-size:65px;font-weight:700;margin-top:0;margin-bottom:10px;color:#151723;text-transform:uppercase}.notfound h2{font-family:nunito,sans-serif;font-size:21px;font-weight:400;margin:0;text-transform:uppercase;color:#151723}.notfound p{font-family:nunito,sans-serif;color:#999fa5;font-weight:400}.notfound a{font-family:nunito,sans-serif;display:inline-block;font-weight:700;border-radius:40px;text-decoration:none;color:#388dbc}@media only screen and (max-width:767px){.notfound .notfound-404{width:110px;height:110px}.notfound{padding-left:15px;padding-right:15px;padding-top:110px}}
        </style>
    </head>
    <body class="antialiased">
        <div id="notfound">
            <div class="notfound">
                <h1>@yield('code')</h1>
                <h2>@yield('message')</h2>
                <p>@yield('description')</p>
                <a href="{{url('/')}}">@lang('Back to home-page')</a>
            </div>
        </div>
    </body>
</html>
