<x-admin-layout title="Citas" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Citas']
]">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Citas Médicas</h1>
            </div>
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <a href="{{ route('admin.appointments.create') }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg px-4 py-2 font-medium">
                    <i class="fa-solid fa-plus mr-2"></i>Nueva Cita
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
            <div class="p-3">
                <div class="overflow-x-auto">
                    <table class="table-auto w-full dark:text-slate-300">
                        <thead class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/20 border-t border-b border-slate-200 dark:border-slate-700">
                            <tr>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">Paciente</div></th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">Doctor</div></th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">Fecha</div></th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">Hora</div></th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-center">Estatus</div></th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-center">Acciones</div></th>
                            </tr>
                        </thead>

                        <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach($appointments as $appointment)
                            <tr>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800 dark:text-slate-100">{{ $appointment->patient->user->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800 dark:text-slate-100">{{ $appointment->doctor->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                    @if($appointment->status == 1)
                                        <span class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5 bg-emerald-100 dark:bg-emerald-400/30 text-emerald-600 dark:text-emerald-400">Programada</span>
                                    @else
                                        <span class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">Terminada</span>
                                    @endif
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="space-x-1 text-center">
                                        @include('admin.appointments.actions', ['appointment' => $appointment])
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4">
            {{ $appointments->links() }}
        </div>
    </div>
</x-admin-layout>
