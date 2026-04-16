@props([
    'title' => config('app.name', 'Vitalia'),
    'breadcrumbs' => []
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
        <script src="https://kit.fontawesome.com/6244811c40.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <wireui:scripts />
    </head>
    <body class="font-sans antialiased bg-gray-100">

        @include('layouts.includes.admin.navigation')
        @include('layouts.includes.admin.sidebar')

        <div class="p-4 sm:ml-64 mt-14">
            <div class="mt-14 flex justify-between items-center w-full">
                @include('layouts.includes.admin.breadcrumbs')
                @isset($action)
                    <div>{{ $action }}</div>
                @endisset
            </div>
            {{ $slot }}
        </div>

        @stack('modals')

        @if(session('swal'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: "{{ session('swal.icon') }}",
                        title: "{{ session('swal.title') }}",
                        text: "{{ session('swal.text') }}",
                    });
                });
            </script>
        @endif

        @livewireScripts
        @yield('content')

        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    </body>
</html>
