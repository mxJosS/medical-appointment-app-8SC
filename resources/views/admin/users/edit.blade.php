<x-admin-layout title="Usuarios" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Usuarios', 'href' => route('admin.users.index')],
    ['name' => 'Editar',]
]">
    <x-wire-card>
        <x-validation-errors class="mb-4"></x-validation-errors>
        <form action="{{route('admin.users.update', $user->id)}}" method="POST">
            {{-- Pregunta de examen: CSRF (Cross Side Request Forgery)  --}}
            @csrf
            @method('PUT')
         
            <div class="space-y-4">
                <div class="grid lg:grid-cols-2 gap-4">
                    <x-wire-input label="Nombre" name="name" placeholder="Nombre Completo" value="{{ old('name', $user->name) }}">
                    </x-wire-input>

                    <x-wire-input label="Email" name="email" type="email" placeholder="Email" value="{{ old('email', $user->email) }}">
                    </x-wire-input>
                    
                    <x-wire-input label="Contraseña" name="password" type="password" placeholder="Contraseña" autocomplete="new-password">
                    </x-wire-input>
                    
                    <x-wire-input label="Confirmar contraseña" name="password_confirmation" type="password" placeholder="Confirmar contraseña" autocomplete="new-password">
                    </x-wire-input>
                    
                    <x-wire-input label="Número de ID" name="id_number" placeholder="Número de ID" value="{{ old('id_number', $user->id_number) }}">
                    </x-wire-input>
                    
                    <x-wire-input label="Teléfono" name="phone" placeholder="Teléfono" autocomplete="tel" value="{{ old('phone', $user->phone) }}">
                    </x-wire-input>
                </div>

                <x-wire-input name="address" label="Dirección" required placeholder="Ej. Calle 90 293" autocomplete="street-address" value="{{ old('address', $user->address) }}">
                </x-wire-input>

                <div class="space-y-1">
                    <x-wire-native-select name="role_id" label="Rol" required>
                        <option value="">
                            Seleccione un rol
                        </option>
                  
                        @foreach ($roles as $role)
                          
                            <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </x-wire-native-select>
                    <p class="text-sm text-gray-500">Define los permisos y accesos del usuario.</p>
                </div>

                <div class="flex justify-end">
                    <x-wire-button type="submit" color="green">
                        Actualizar
                    </x-wire-button>
                </div>
            </div> 
        </form>
    </x-wire-card>
</x-admin-layout>