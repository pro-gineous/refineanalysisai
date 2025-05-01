<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Refine Analysis') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS - Production Version -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        blue: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        primary: {
                            DEFAULT: '#0284c7',
                            dark: '#0369a1',
                        },
                        background: '#F0F4F9'
                    }
                }
            }
        }
    </script>
    
    <!-- Custom CSS -->
    <style>
        [x-cloak] { display: none !important; }
        body {
            background-color: #F0F4F9;
        }
    </style>
</head>
<body class="font-sans antialiased" style="background-color: #F0F4F9;">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <main>
            @yield('content')
        </main>
        
        @include('layouts.footer')
    </div>
</body>
</html>