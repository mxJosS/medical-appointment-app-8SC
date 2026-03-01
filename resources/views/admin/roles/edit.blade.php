<x-admin-layout title="Roles" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Roles', 'href' => route('admin.roles.index')],
    ['name' => 'Editar'],
]">
 <x-wire-card>
        <form action="{{route('admin.roles.update', $role)}}" method="POST">
            {{-- Pregunta de examen: CSRF (Cross Side Request Forgery)  --}}
            @csrf
            @method('PUT')
            <x-wire-input label="Nombre" name="name" placeholder="Nombre del rol" value="{{ old('name', $role->name) }}" >
                
            </x-wire-input>
            <div class="flex justify-end mt-4">
                <x-wire-button type="submit" color="green">
                    Actualizar
                </x-wire-button>
            </div>
        </form>
    </x-wire-card>

</x-admin-layout>