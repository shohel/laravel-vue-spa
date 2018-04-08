<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>A Blogging platform open for all</title>


    <meta name="description" content="A Simple VUE SPA application made with laravel and VueJS" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="A Simple VUE SPA application made with laravel and VueJs">
    <meta name="twitter:title" content="A Blogging platform open for all">
    <meta name="twitter:description" content="A Blogging platform open for all made with Laravel and VueJS">
    <meta name="twitter:image" content="{{asset('assets/images/features.jpg')}}">

    <!-- Open Graph data -->
    <meta property="og:title" content="A Blogging platform open for all" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="{{asset('assets/images/features.jpg')}}" />
    <meta property="og:description" content="A Blogging platform open for all made with Laravel and VueJS" />
    <meta property="og:site_name" content="Blogging Platform" />


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/fontawesome/css/fontawesome-all.min.css')}}">
    <!-- Styles -->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <script>
        var laravel = {!! get_json_data() !!}
    </script>
</head>
<body>

<div id="vue-app"></div>


<footer class="p-3 p-md-5 bg-light">
    <p class="text-center">&copy; Copyright {{date('Y')}}, All rights reserved</p>
</footer>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/vue.js') }}" defer></script>
</body>
</html>
