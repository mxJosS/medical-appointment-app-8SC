@php
   $links = [
       [
           'name' => 'Dashboard',
           'icon' => 'fa-solid fa-gauge',
           'href' => route("admin.dashboard"),
           'active' => request()->routeIs("admin.dashboard")
       ],
       ['header' => 'Gestión'],
       [
           'name' => 'Citas',
           'icon' => 'fa-solid fa-calendar',
           'href' => route("admin.dashboard"),
           'active' => request()->routeIs("admin.dashboard")
       ],
       [
           'name' => 'Roles y permisos',
           'icon' => 'fa-solid fa-shield-halved',
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

   ];
@endphp

<aside id="top-bar-sidebar" class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
   <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-primary-soft border-e border-default">
      <a href="#" class="flex items-center ps-2.5 mb-5">
         <img src="{{ asset('images/vitalia_logo.jpg') }}" class="h-6 me-3" alt="Vitalia Logo" />
         <span class="self-center text-lg text-heading font-semibold whitespace-nowrap">Vitalia</span>
      </a>
      <ul class="space-y-2 font-medium">
         @foreach ($links as $link)
            <li>
               @isset($link['header'])
                  <div class="px-2 py-2 text-xs font-semibold text-gray-500 uppercase">
                     {{ $link['header'] }}
                  </div>
               @else
                  @isset($link['submenu'])
                     {{-- Botón para desplegar Submenú --}}
                     <button type="button"
                             class="flex items-center w-full justify-between px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group"
                             data-collapse-toggle="dropdown-{{ $loop->index }}">
                        <span class="inline-flex items-center">
                           <span class="w-6 h-6 inline-flex items-center justify-center text-gray-500">
                              <i class="{{ $link['icon'] }}"></i>
                           </span>
                           <span class="ms-3 text-left whitespace-nowrap">{{ $link['name'] }}</span>
                        </span>
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                        </svg>
                     </button>

                     <ul id="dropdown-{{ $loop->index }}" class="hidden py-2 space-y-2">
                        @foreach ($link['submenu'] as $sub)
                           <li>
                              <a href="{{ $sub['href'] }}" class="pl-10 flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                                 {{ $sub['name'] }}
                              </a>
                           </li>
                        @endforeach
                     </ul>
                  @else
                     {{-- Enlace simple sin submenú --}}
                     <a href="{{ $link['href'] }}" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{ $link['active'] ? 'bg-gray-100' : '' }}">
                        <span class="w-6 h-6 inline-flex items-center justify-center text-gray-500">
                           <i class="{{ $link['icon'] }}"></i>
                        </span>
                        <span class="ms-3">{{ $link['name'] }}</span>
                     </a>
                  @endisset
               @endisset
            </li>
         @endforeach
      </ul>
   </div>
</aside>
