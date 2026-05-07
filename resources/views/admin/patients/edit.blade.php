{{-- Lógica de php para manejar errores y controlar la pestaña activa  --}}
@php
    // Definimos qué campos pertenecen a cada pestaña para detectar los errores y mostrar la pestaña correspondiente
    $errorGroups = [
        'antecedentes' => ['allergies', 'chronic_conditions', 'surgical_history', 'family_history'],
        'informacion-general' => ['blood_type_id', 'observations'],
        'contacto-emergencia' => [
            'emergency_contact_name',
            'emergency_contact_phone',
            'emergency_contact_relationship',
        ],
    ];

    $hasErrorAntecedentes = $errors->hasAny($errorGroups['antecedentes']);
    $hasErrorInfoGeneral = $errors->hasAny($errorGroups['informacion-general']);
    $hasErrorContacto = $errors->hasAny($errorGroups['contacto-emergencia']);
    $hasErrorDatos = false;

    // pestaña por defecto
    $initialTab = 'datos-personales';

    // Lógica para abrir la pestaña con errores
    if ($hasErrorAntecedentes) {
        $initialTab = 'antecedentes';
    } elseif ($hasErrorInfoGeneral) {
        $initialTab = 'informacion-general';
    } elseif ($hasErrorContacto) {
        $initialTab = 'contacto-emergencia';
    }
@endphp

<x-admin-layout title="Pacientes" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Pacientes', 'href' => route('admin.patients.index')],
    ['name' => 'Editar'],
]">

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <x-wire-card>
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
                    <x-wire-button type="submit"> <i class="fa-solid fa-check me-2"></i>Guardar</x-wire-button>
                </div>
            </div>
        </x-wire-card>

        <br>

        <x-wire-card>
            {{-- Implementación de los nuevos componentes Blade --}}
            <x-tabs :active="$initialTab">

                {{-- Slots de navegación --}}
                <x-slot name="header">
                    <x-tabs-link tab="datos-personales" :error="$hasErrorDatos">
                        <i class="fa-solid fa-user me-2"></i> Datos personales
                    </x-tabs-link>

                    <x-tabs-link tab="antecedentes" :error="$hasErrorAntecedentes">
                        <i class="fa-solid fa-file-medical me-2"></i> Antecedentes
                    </x-tabs-link>

                    <x-tabs-link tab="informacion-general" :error="$hasErrorInfoGeneral">
                        <i class="fa-solid fa-info me-2"></i> Información general
                    </x-tabs-link>

                    <x-tabs-link tab="contacto-emergencia" :error="$hasErrorContacto">
                        <i class="fa-solid fa-phone-alt me-2"></i> Contacto de Emergencia
                    </x-tabs-link>
                </x-slot>

                {{-- Contenido del tab 1: datos personales --}}
                <x-tab-content tab="datos-personales">
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
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
                </x-tab-content>
                {{-- Contenido del tab 2: Antecedentes --}}
                <x-tab-content tab="antecedentes">
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
                </x-tab-content>
                {{-- Contenido del tab 3: información general --}}
                <x-tab-content tab="informacion-general">
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
                </x-tab-content>
                {{-- Contenido del tab 4: Contacto de emergencia --}}
                <x-tab-content tab="contacto-emergencia">
                    <div class="space-y-4">
                        <x-wire-input label="Nombre del contacto" name="emergency_contact_name"
                            value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" />
                        <x-wire-phone label="Teléfono de contacto" name="emergency_contact_phone" type="tel"
                            mask="(###) ###-####" placeholder="(123) 456-7890"
                            value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" />
                        <div class="md:col-span-2">
                            <x-wire-input label="Relación con el paciente" name="emergency_contact_relationship"
                                value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}"
                                placeholder="Familiar, amigo, etc." />
                        </div>
                    </div>
                </x-tab-content>
            </x-tabs>
        </x-wire-card>
    </form>
</x-admin-layout>
