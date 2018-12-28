<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- -->

    <title>{{ config('app.name', 'vivaenzCRM') }}</title>

   
 {{-- <!-- Scripts -->
 <script src="{{ asset('js/app.js') }}" defer></script>

 <!-- Fonts -->
 <link rel="dns-prefetch" href="https://fonts.gstatic.com">
 <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <style>

        .anyClass {
            height:150px;
            overflow-y: scroll;
        }

         .positionable {
            position: absolute;
        }

    </style>--}}
</head>
<body>

    <div id="dvMain" class="row h-100" >

        <div class="col-2 h-100">

            @include('inc.menubar')

        </div>

        <div class="col-10">

            <div class="row" >

                @include('inc.navbar')

                <div class="col-8 mt-2 pt-5" >

                    @yield('content')

                </div>

                <div id="dvMessages" class="col-3 mt-5 pt-5" >

                    @include('inc.messages')

                </div>

            </div>

        </div>

    </div>
    <!--<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>-->
    <script>
        jQuery(document).ready(function() {
            console.log('ready');
            @yield('postJquery');
        });
    </script>

    {{-- <div id="app">
        

        <main class="py-4">
            @yield('content')
        </main>
    </div> --}}
</body>
</html>
