<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta name='csrf-token' content="{{ csrf_token() }}" />

        <title>{{env('APP_NAME', 'HouseBudget')}}</title>

        {{-- FONT --}}
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet"> 

        {{-- FONTAWESOME --}}
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />

        {{-- BOOTSTRAP --}}
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

        {{-- GLOBAL --}}
        <link rel = 'stylesheet' href = '{{asset('css/master.css')}}' />

        {{-- ANIMATE CSS --}}
        <link rel = 'stylesheet' href = '{{asset('css/plugins/animate.css')}}' />

        {{-- toastr --}}
        @toastr_css

        {{-- Styles specific to a view --}}
        @yield('styles')
    </head>
    <body class="position-relative">
        {{-- NAVIGATIONS --}}
        {{-- @include('components.navigation') --}}

        {{-- View's content --}}
        @yield('content')

        {{-- JQUERY --}}
        <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>

        {{-- POPPER --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        {{-- BOOTSTRAP --}}
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        {{-- toastr --}}
        @toastr_js
        @toastr_render

        {{-- Scripts specific to a view --}}
        @yield('scripts')
    </body>
</html>
