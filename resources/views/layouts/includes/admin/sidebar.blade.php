@php
    $links = [
        [
            'name' => 'Dashboard',
            'icon' => 'fa-solid fa-chart-pie',
            'href' => route("admin.dashboard"),
            'active' => request()->routeIs("admin.dashboard")
        ],
        ['header' => 'Gestión'],
        [
            'name' => 'Roles y Permisos',
            'icon' => 'fa-solid fa-shield',
            'href' => route("admin.roles.index"),
            'active' => request()->routeIs("admin.roles.*"),
        ],
        [
            'name' => 'Usuarios',
            'icon' => 'fa-solid fa-users',
            'href' => route("admin.users.index"),
            'active' => request()->routeIs("admin.users.*"),
        ],
        [
            'name' => 'Pacientes',
            'icon' => 'fa-solid fa-user-injured',
            'href' => route("admin.patients.index"),
            'active' => request()->routeIs("admin.patients.*"),
        ],
        [
            'name' => 'Doctores',
            'icon' => 'fa-solid fa-user-doctor',
            'href' => route("admin.doctors.index"),
            'active' => request()->routeIs("admin.doctors.*"),
        ],
        [
            'name' => 'Citas médicas',
            'icon' => 'fa-solid fa-calendar-check',
            'href' => route("admin.appointments.index"),
            'active' => request()->routeIs("admin.appointments.*")
        ],
        [
            'name' => 'Calendario',
            'icon' => 'fa-solid fa-calendar',
            'href' => '#',
            'active' => false
        ],
        [
            'name' => 'Soporte',
            'icon' => 'fa-solid fa-headset',
            'href' => '#',
            'active' => false
        ],
    ];
@endphp

<div x-data="{ open: false }" x-on:toggle-sidebar.window="open = !open">
    <div x-show="open"
         x-on:click="open = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-900/50 z-30 sm:hidden"
         style="display: none;">
    </div>


    <aside id="top-bar-sidebar"
           class="fixed top-0 left-0 z-40 w-64 h-full transition-transform border-e border-default bg-white sm:translate-x-0"
           :class="open ? 'translate-x-0' : '-translate-x-full'"
           aria-label="Sidebar">

        <div class="h-full px-3 py-4 overflow-y-auto">

            <a href="{{ route('welcome') }}" class="flex justify-center items-center w-full mt-4 mb-8 gap-3 group">
                <img src="{{ asset('images/logo_vitalia.png') }}" class="h-12 w-auto" alt="Vitalia Logo" />
                <span class="text-3xl font-extrabold text-gray-800 tracking-tight">Vitalia</span>
            </a>

            <ul class="space-y-2 font-medium">
                @foreach ($links as $link)
                    <li>
                        @isset($link['header'])
                            <div class="px-2 py-2 text-xs font-semibold text-gray-500 uppercase">
                                {{ $link['header'] }}
                            </div>
                        @else
                            <a href="{{ $link['href'] }}" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{ $link['active'] ? 'bg-gray-100' : '' }}">
                                <span class="w-6 h-6 inline-flex items-center justify-center text-gray-500">
                                    <i class="{{ $link['icon'] }}"></i>
                                </span>
                                <span class="ms-3">{{ $link['name'] }}</span>
                            </a>
                        @endisset
                    </li>
                @endforeach
            </ul>
        </div>
    </aside>
</div>
