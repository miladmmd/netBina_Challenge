<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="robots" content="noindex" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5" />

        <title>Laravel</title>

        @vite('resources/js/app.js')
    </head>
    <body>
       <div id="app"></div>
    </body>
</html>
