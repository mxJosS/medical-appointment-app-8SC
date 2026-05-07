<x-admin-layout title="Editar Cita" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Citas', 'href' => route('admin.appointments.index')],
    ['name' => 'Editar']
]">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Editar Cita #{{ $appointment->id }}</h1>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
            <div class="p-6">
                <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Paciente -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1" for="patient_id">Paciente <span class="text-rose-500">*</span></label>
                            <select id="patient_id" name="patient_id" class="form-select w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300" required>
                                <option value="">Seleccione un paciente</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->user->name ?? 'Sin nombre' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('patient_id') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Doctor -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1" for="doctor_id">Doctor <span class="text-rose-500">*</span></label>
                            <select id="doctor_id" name="doctor_id" class="form-select w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300" required>
                                <option value="">Seleccione un doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('doctor_id') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Fecha -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1" for="date">Fecha <span class="text-rose-500">*</span></label>
                            <input id="date" name="date" type="date" value="{{ old('date', $appointment->date) }}" class="form-input w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300" required />
                            @error('date') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Hora de inicio -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1" for="start_time">Hora de inicio <span class="text-rose-500">*</span></label>
                            <input id="start_time" name="start_time" type="time" value="{{ old('start_time', \Carbon\Carbon::parse($appointment->start_time)->format('H:i')) }}" class="form-input w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300" required />
                            @error('start_time') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Hora de término -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1" for="end_time">Hora de término <span class="text-rose-500">*</span></label>
                            <input id="end_time" name="end_time" type="time" value="{{ old('end_time', \Carbon\Carbon::parse($appointment->end_time)->format('H:i')) }}" class="form-input w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300" required />
                            @error('end_time') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Motivo -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1" for="reason">Motivo de la Cita</label>
                        <textarea id="reason" name="reason" rows="4" class="form-textarea w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300">{{ old('reason', $appointment->reason) }}</textarea>
                        @error('reason') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.appointments.index') }}" class="btn border-slate-200 hover:border-slate-300 text-slate-600 rounded-lg px-4 py-2 font-medium">Cancelar</a>
                        <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg px-4 py-2 font-medium">Actualizar Cita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
