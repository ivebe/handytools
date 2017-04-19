<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>List of handy tools</title>

    <link href="{!! asset('css/app.css') !!}" rel="stylesheet" type="text/css">

    <style>
        .component-fade-enter-active, .component-fade-leave-active {
            transition: opacity .3s ease;
        }

        .component-fade-enter, .component-fade-leave-to {
            opacity: 0;
        }
    </style>
</head>
<body>
<div id="app">
    <navbar-top></navbar-top>
    <div class="container" style="margin-top:70px;">
        <transition name="component-fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</div>

<script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};</script>
<script src="https://cdn.jsdelivr.net/lodash/4.17.4/lodash.min.js"></script>
<script src="{!! asset('js/app.js') !!}"></script>
</body>
</html>
