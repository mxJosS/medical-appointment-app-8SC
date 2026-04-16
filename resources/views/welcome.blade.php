<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Vitalia - Tu Sistema de Salud</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
          @livewireStyles
        <script src="https://kit.fontawesome.com/6244811c40.js" crossorigin="anonymous"></script>
    </head>
    <body class="font-sans antialiased text-gray-800 bg-white">

    <nav class="bg-white border-b border-gray-100 sticky shadow-lg rounded-lg top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo_vitalia.png') }}" class="h-10 w-auto" alt="Logo">
                <span class="text-2xl font-bold text-gray-800 tracking-tight">Vitalia</span>
            </div>

            <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-600">
                <a href="#" class="hover:text-teal-600 transition">Inicio</a>
                <a href="#funcionalidades" class="hover:text-teal-600 transition:smooth">Funcionalidades</a>
                <a href="#" class="hover:text-teal-600 transition:smooth">Contacto</a>
            </div>

           <div class="flex items-center gap-4">
    @if (Route::has('login'))
        @auth
            <a href="{{ url('/admin') }}" class="text-sm font-semibold text-teal-600 border border-teal-600 px-4 py-2 rounded-lg hover:bg-teal-50 transition">
                Ir al Dashboard
            </a>
        @else

            <a href="{{ route('login') }}" class="text-sm font-semibold text-teal-600 border border-teal-600 px-4 py-2 rounded-lg hover:bg-teal-50 transition">
                Iniciar Sesión
            </a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="text-sm font-semibold bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 shadow-md transition">
                    Registrarse
                </a>
            @endif
        @endauth
    @endif
</div>
        </div>
    </div>
</nav>
<header class="relative bg-gradient-to-b from-teal-50 to-white py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-tight">
                Vitalia: Tu Salud <br>
                <span class="text-teal-600">Digital, Simple y Segura.</span>
            </h1>
            <p class="mt-6 text-lg text-gray-600 leading-relaxed">
                Agenda citas, gestiona tu historial y comunícate con especialistas.
                Todo en un solo lugar, diseñado para tu bienestar.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4">
                <a href="{{ route('register') }}" class="bg-teal-600 text-white px-8 py-4 rounded-xl font-bold text-center hover:bg-teal-700 shadow-lg transition-all hover:-translate-y-1">
                    Comenzar Gratis
                </a>
                <a href="#funcionalidades" class="bg-white text-gray-700 border border-gray-200 px-8 py-4 rounded-xl font-bold text-center hover:bg-gray-50 transition">
                    Saber Más
                </a>
            </div>
        </div>

        <div class="flex justify-center">
            <img src="{{ asset('images/doctores_vitalia.png') }}"
                 alt="Médicos Vitalia"
                 class="w-full max-w-lg drop-shadow-2xl animate-pulse-slow">
        </div>
    </div>
</header>
<section id="funcionalidades" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-16">Todo lo que Vitalia ofrece para ti</h2>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="p-8 bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 bg-teal-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-teal-600 transition-colors">
                    <i class="fa-solid fa-calendar-check text-teal-600  text-2xl group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Citas Médicas</h3>
                <p class="text-gray-600">Agenda, cancela o reprograma citas con un par de clics desde cualquier dispositivo.</p>
            </div>

            <div class="p-8 bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 bg-teal-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-teal-600 transition-colors">
                    <i class="fa-solid fa-file-invoice-dollar text-teal-600 text-2xl group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Historial Clínico</h3>
                <p class="text-gray-600">Tu información médica siempre contigo, protegida y organizada de forma inteligente.</p>
            </div>

            <div class="p-8 bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 bg-teal-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-teal-600 transition-colors">
                    <i class="fa-solid fa-user-doctor text-teal-600 text-2xl group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Gestión Integral</h3>
                <p class="text-gray-600">Control total para médicos y pacientes en una interfaz intuitiva y moderna.</p>
            </div>
        </div>
    </div>
</section>
<footer class="bg-gray-50 border-t border-gray-100 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">

            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('images/logo_vitalia.png') }}" class="h-8 w-auto filter grayscale opacity-80" alt="Logo">
                    <span class="text-xl font-bold text-gray-700 tracking-tight">Vitalia</span>
                </div>
                <p class="text-gray-500 max-w-sm">
                    Proyecto de semestre para la metria: Desarrollo Backend de la especialidad de desarrollo web y aplicaciones móviles.
                    Sistema de gestión de pacientes para consultorios médicos, con funcionalidades de agenda, historial clínico y comunicación entre médicos y pacientes.
                    Desarrollado bajo la supervisión del docente: Rodrigo Fidel Gaxiola Sosa. Instituto Tecnológico de Mérida.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Plataforma</h4>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li><a href="#" class="hover:text-teal-600 transition:smooth">Inicio</a></li>
                    <li><a href="#funcionalidades" class="hover:text-teal-600 transition:smooth">Funcionalidades</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-teal-600 transition:smooth">Acceso Médicos</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Proyecto</h4>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li><span class="block italic text-gray-400">Desarrollado por:</span></li>
                    <li>Jose Angel Espinosa G.</li>
                    <li>Instituto Tecnológico de Mérida</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm text-gray-400">
                &copy; {{ date('Y') }} Vitalia Health.
            </p>
            <div class="flex gap-6 text-gray-400 text-sm">
                <a href="#" class="hover:text-teal-600 transition">Privacidad</a>
                <a href="#" class="hover:text-teal-600 transition">Términos</a>
            </div>
        </div>
    </div>
</footer>



    </body>
</html>
