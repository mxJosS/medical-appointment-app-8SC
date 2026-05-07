<x-admin-layout title="Nueva Cita" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Citas', 'href' => route('admin.appointments.index')],
    ['name' => 'Nuevo']
]">
    @livewire('admin.appointments.create-appointment')
</x-admin-layout>
