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

        {{-- navigation --}}
        <link rel = 'stylesheet' href = '{{asset('css/nav.css')}}' />

        {{-- toastr --}}
        @toastr_css

        {{-- chart js --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css">

        {{-- Styles specific to a view --}}
        @yield('styles')
    </head>
    <body class="position-relative">
        {{-- navigation --}}
        @include('components.dashboard.nav')
        @include('components.dashboard.menu')

        {{-- View's content --}}
        <div style="padding-top: 100px;">
            @yield('content')
        </div>



        {{-- JQUERY --}}
        <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>

        {{-- POPPER --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        {{-- BOOTSTRAP --}}
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        {{-- navigation --}}
        <script src="{{ asset("js/nav.js") }}"></script>

        {{-- toastr --}}
        @toastr_js
        @toastr_render

        {{-- chart js --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>

        {{-- Scripts specific to a view --}}
        @yield('scripts')
    </body>
</html>
