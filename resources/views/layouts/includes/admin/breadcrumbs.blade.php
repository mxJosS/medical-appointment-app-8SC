{{-- Verificar si hay elementos en el arreglo breadcrumbs --}}
@if (count($breadcrumbs))
    <nav class="mb-2 block">
        <ol class="flex flex-wrap text-slate-700 text-sm">
            @foreach ($breadcrumbs as $item)
                <li class="flex items-center">
                    {{-- Si no es el primer elemento, pinta el separador --}}
                    @unless ($loop->first)
                        <span class="px-2 text-gray-400">/</span>
                    @endunless

                    {{-- CORRECCIÓN AQUÍ: Uso de corchetes para acceder al array --}}
                    @isset($item['href'])
                        <a href="{{ $item['href'] }}" class="opacity-60 hover:opacity-100 transition">
                            {{ $item['name'] }}
                        </a>
                    @else
                        {{-- Si no tiene enlace, es el texto simple --}}
                        {{ $item['name'] }}
                    @endisset
                </li>
            @endforeach
        </ol>

        {{-- Mostrar el título del último elemento resaltado --}}
        @if (count($breadcrumbs) > 0)
            <h6 class="font-bold mt-2">
                {{ end($breadcrumbs)['name'] }}
            </h6>
        @endif
    </nav>
@endif