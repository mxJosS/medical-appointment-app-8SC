@php
   //Arreglo de iconos
   $links = [[
      'name' => 'Dashboard',
      'icon' => 'fa-solid fa-gauge',
      'href' => 'route("admin.dashboard")',
      'active' => request()->routeIs("admin.dashboard")
   ],
   [
      'name' => 'Personas',
      'icon' => 'fa-solid fa-users',
      'href' => 'route("admin.personas")',
      'active' => request()->routeIs("admin.personas")
   ],
   [
      'header' => 'Administración',
   ],
   [
      'name' => 'Citas',
      'icon' => 'fa-solid fa-calendar',
      'href' => 'route("admin.citas")',
      'active' => request()->routeIs("admin.citas")
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
            {{--Revisa si existe una llave/propiedad llamada 'Header' --}}
            @isset($link['header'])
               <div class="px-2 py-2 text-xs font-semibold tex-gray-500 uppercase">
                  {{ $link['header'] }}
               </div>
            @else
            <a href="{{ $link['href'] }}" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{ $link['active'] ? 'bg-gray-100' : '' }}">
               <span class="w-6 h6 inline-flex items-center justify-center text-gray-500">
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