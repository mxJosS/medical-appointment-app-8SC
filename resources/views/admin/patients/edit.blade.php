<x-admin-layout title="Pacientes" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Pacientes', 'href' => route('admin.patients.index')],
    ['name' => 'Editar'],
]">

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')
        <x-wire-card >
            <div class="lg:flex lg:justify-between lg:items-center">
                <div class="flex items-center">
                    <img src="{{ $patient->user->profile_photo_url }}" alt="{{ $patient->user->name }}"
                        class="w-20 h-20 rounded-full mr-4 object-cover object-center">
                    <div class="px-4 py-2">
                        <p class="text-2xl font-bold text-gray-900">{{ $patient->user->name }}</p>
                    </div>
                </div>
                <div class="flex space-x-3 mt-6 lg:mt-0">
                    <x-wire-button outline gray href="{{ route('admin.patients.index') }}">Regresar</x-wire-button>
                    <x-wire-button type="submit"> <i class="fa-solid fa-check"></i>Guardar</x-wire-button>
                </div>
            </div>
        </x-wire-card>
        <br>
        {{-- tabs de navegación --}}
        <x-wire-card>
            <div x-data="{ tab: 'datos-personales' }">
                {{-- menú de pestañas --}}
                <div class="border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
                        {{-- Tab 1: Datos personales --}}
                        <li class="me-2">
                            <a href="#" x-on:click="tab = 'datos-personales'"
                                :class="{ 'text-blue-600 border-blue-600 active': tab === 'datos-personales', 'border-transparent hover:border-gray-300': tab !== 'datos-personales' }"
                                class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200"
                                :aria-current="tab === 'datos-personales' ? 'page' : null">
                                <i class="fa-solid fa-user me-2"></i> Datos personales
                            </a>
                        </li>
                        {{-- Tab 2: Antecedentes --}}
                        <li class="me-2">
                            <a href="#" x-on:click="tab = 'antecedentes'"
                                :class="{ 'text-blue-600 border-blue-600 active': tab === 'antecedentes', 'border-transparent hover:border-gray-300': tab !== 'antecedentes' }"
                                class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200"
                                :aria-current="tab === 'antecedentes' ? 'page' : null">
                                <i class="fa-solid fa-file-medical me-2"></i> Antecedentes
                            </a>
                        </li>
                        {{-- Tab 3: Información general --}}
                        <li class="me-2">
                            <a href="#" x-on:click="tab = 'informacion-general'"
                                :class="{ 'text-blue-600 border-blue-600 active': tab === 'informacion-general', 'border-transparent hover:border-gray-300': tab !== 'informacion-general' }"
                                class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200"
                                :aria-current="tab === 'informacion-general' ? 'page' : null">
                                <i class="fa-solid fa-info me-2"></i> Información general
                            </a>
                        </li>
                        {{-- Tab 4: Contacto de Emergencia --}}
                        <li class="me-2">
                            <a href="#" x-on:click="tab = 'contacto-emergencia'"
                                :class="{ 'text-blue-600 border-blue-600 active': tab === 'contacto-emergencia', 'border-transparent hover:border-gray-300': tab !== 'contacto-emergencia' }"
                                class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200"
                                :aria-current="tab === 'contacto-emergencia' ? 'page' : null">
                                <i class="fa-solid fa-phone-alt me-2"></i> Contacto de Emergencia
                            </a>
                        </li>
                    </ul>
                </div>
                {{-- Contenido de los tabs --}}
                <div class="px-4 mt-4">
                    {{-- Contenido del tab 1: datos personales --}}
                    <div x-show="tab === 'datos-personales'">
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg shadow-sm">
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                                {{-- Lado izquierdo: Información --}}
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="fa-solid fa-user-gear text-blue-500 text-xl mt-1"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-bold text-blue-800">Edición de usuario</h3>
                                        <div class="mt-1 text-sm text-blue-600">
                                            <p>
                                                <strong>La información de acceso</strong> (Nombre, correo y contraseña)
                                                debe de gestionarse desde la cuenta de usuarios asociada:
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                {{-- Lado derecho: Botón de acción --}}
                                <div class="flex-shrink-0">
                                    <x-wire-button primary sm href="{{ route('admin.users.edit', $patient->user) }}"
                                        target="_blank">
                                        Editar usuario
                                        <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                                    </x-wire-button>
                                </div>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2 gap-4">
                            <div>
                                <span class="text-gray-500 font-semibold">Teléfono:</span>
                                <span class="text-gray-900 text-sm ml-1">{{ $patient->user->phone }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 font-semibold">Correo electrónico:</span>
                                <span class="text-gray-900 text-sm ml-1">{{ $patient->user->email }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 font-semibold">Dirección:</span>
                                <span class="text-gray-900 text-sm ml-1">{{ $patient->user->address }}</span>
                            </div>
                        </div>
                    </div>
                    {{-- Contenido del tab 2: Antecedentes --}}
                    <div x-show="tab === 'antecedentes'">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-wire-textarea label="Alergias conocidas" name="allergies">
                                {{ old('allergies', $patient->allergies) }}
                            </x-wire-textarea>
                            <x-wire-textarea label="Enfermedades crónicas" name="chronic_conditions">
                                {{ old('chronic_conditions', $patient->chronic_conditions) }}
                            </x-wire-textarea>
                            <x-wire-textarea label="Antecedentes quirúrgicos" name="surgical_history">
                                {{ old('surgical_history', $patient->surgical_history) }}
                            </x-wire-textarea>
                            <x-wire-textarea label="Historial familiar" name="family_history">
                                {{ old('family_history', $patient->family_history) }}
                            </x-wire-textarea>
                        </div>
                    </div>
                    {{-- Contenido del tab 3: información general --}}
                    <div x-show="tab === 'informacion-general'">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-wire-native-select label="Tipo de sangre" name="blood_type_id">
                                    <option value="">Selecciona un tipo de sangre</option>
                                    @foreach ($bloodTypes as $bloodType)
                                        <option value="{{ $bloodType->id }}" @selected(old('blood_type_id', $patient->blood_type_id) == $bloodType->id)>
                                            {{ $bloodType->name }}
                                        </option>
                                    @endforeach
                                </x-wire-native-select>
                            </div>
                            <div></div>
                            <div class="md:col-span-2">
                                <x-wire-textarea label="Observaciones" name="observations" rows="4">
                                    {{ old('observations', $patient->observations) }}
                                </x-wire-textarea>
                            </div>
                        </div>
                    </div>
                    {{-- Contenido del tab 4: Contacto de emergencia --}}
                    <div x-show="tab === 'contacto-emergencia'">
                        <div class="space-y-4 ">
                            <x-wire-input label="Nombre del contacto" name="emergency_contact_name"
                                value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"  />
                            <x-wire-phone label="Teléfono de contacto" name="emergency_contact_phone" type="tel" mask="(###) ###-####" placeholder="(123) 456-7890"
                                value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" />
                            <div class="md:col-span-2">
                                <x-wire-input label="Relación con el paciente" name="emergency_contact_relationship"
                                    value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}" placeholder="Familiar, amigo, etc." />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </x-wire-card>
    </form>
</x-admin-layout>
