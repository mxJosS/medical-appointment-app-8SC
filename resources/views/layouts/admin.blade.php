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
        
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: "success",
                        title: "¡Éxito!",
                        text: "{{ session('success') }}",
                        showConfirmButton: true
                    });
                });
            </script>
        @endif
        
        @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "{{ session('error') }}",
                    });
                });
            </script>
        @endif

        <!-- Global Delete Confirmation -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.body.addEventListener('submit', function(e) {
                    if (e.target && e.target.tagName === 'FORM') {
                        const methodInput = e.target.querySelector('input[name="_method"]');
                        if (methodInput && methodInput.value.toUpperCase() === 'DELETE') {
                            if (!e.target.dataset.confirmed) {
                                e.preventDefault();
                                Swal.fire({
                                    title: '¿Seguro que deseas eliminar este registro?',
                                    text: "Esta acción no se puede deshacer.",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sí, eliminar',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        e.target.dataset.confirmed = 'true';
                                        e.target.submit();
                                    }
                                });
                            }
                        }
                    }
                });
            });

            // Listener para alertas de Livewire
            window.addEventListener('swal', function(e) {
                const data = e.detail[0] || e.detail;
                Swal.fire({
                    icon: data.icon || 'success',
                    title: data.title || '¡Éxito!',
                    text: data.text,
                    showConfirmButton: true
                });
            });
        </script>

        @livewireScripts
        @yield('content')

        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    </body>
</html>
