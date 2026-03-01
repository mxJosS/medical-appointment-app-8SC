<div class="flex items-center gap-2">
    <x-wire-button href="{{ route('admin.roles.edit', $role) }}" color="blue" xs>
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline">
        {{-- Csrf es un tipo de ataque al navegador de un usuario que cuenta con una sesion activa en una aplicacion, envia peticiones maliciosas enviadas por un tercero --}}
        @csrf
        @method('DELETE')
        <x-wire-button type="submit" color="red" xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>

    </form>

</div>