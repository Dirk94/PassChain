<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <navigation :logged-in="loggedIn" :name="name" v-on:updateuserdetails="updateUserDetails()"></navigation>

    <div class="container">
        <div class="col-lg-12 col-md-12">
            <transition name="fade" mode="out-in">
                <router-view v-on:updateuserdetails="updateUserDetails()" :propname="name" :propemail="email"></router-view>
            </transition>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
