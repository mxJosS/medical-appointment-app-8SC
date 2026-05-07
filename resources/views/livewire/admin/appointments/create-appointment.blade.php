<div>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        <div class="mb-6 bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-5">
            <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4">Buscar disponibilidad</h2>
            <p class="text-sm text-slate-500 mb-4">Encuentra el horario perfecto para tu cita.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Fecha</label>
                    <input type="date" wire:model="searchDate" class="form-input w-full rounded-md border-slate-300 shadow-sm text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Hora</label>
                    <input type="text" wire:model="searchTimeRange" placeholder="Ej. 08:00 - 10:00" class="form-input w-full rounded-md border-slate-300 shadow-sm text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Especialidad (opcional)</label>
                    <input type="text" wire:model="searchSpecialty" placeholder="Ej. Endocrinología" class="form-input w-full rounded-md border-slate-300 shadow-sm text-sm">
                </div>
                <div>
                    <button wire:click="searchAvailability" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-md text-sm transition duration-150">
                        Buscar disponibilidad
                    </button>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Side: Doctor Availability list -->
            <div class="flex-1 space-y-4">
                @forelse($availableDoctors as $doc)
                    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-5">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-500 flex items-center justify-center font-bold text-lg">
                                {{ $doc['initials'] }}
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-800 dark:text-slate-100">{{ $doc['name'] }}</h3>
                                <p class="text-sm text-indigo-500">{{ $doc['specialty'] }}</p>
                            </div>
                        </div>
                        <div class="border-t border-slate-100 dark:border-slate-700 pt-4">
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">Horarios disponibles:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($doc['slots'] as $slot)
                                    <button wire:click="selectSlot('{{ $doc['id'] }}', '{{ $doc['name'] }}', '{{ $slot }}')"
                                        class="px-4 py-2 rounded-md text-sm font-medium transition duration-150 
                                        @if($selectedDoctorId == $doc['id'] && $selectedTime == $slot)
                                            bg-indigo-500 text-white
                                        @else
                                            bg-indigo-50 text-indigo-500 hover:bg-indigo-100 dark:bg-slate-700 dark:text-indigo-400
                                        @endif
                                        ">
                                        {{ \Carbon\Carbon::parse($slot)->format('H:i') }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-8 text-center text-slate-500">
                        No se encontraron doctores con disponibilidad en la fecha seleccionada.
                    </div>
                @endforelse
            </div>

            <!-- Right Side: Summary and Form -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-5 sticky top-4">
                    <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4 border-b pb-2">Resumen de la cita</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Doctor:</span>
                            <span class="font-medium text-slate-800 dark:text-slate-200">{{ $selectedDoctorName ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Fecha:</span>
                            <span class="font-medium text-slate-800 dark:text-slate-200">{{ $selectedDate ? \Carbon\Carbon::parse($selectedDate)->format('Y-m-d') : '-' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Horario:</span>
                            <span class="font-medium text-slate-800 dark:text-slate-200">
                                @if($selectedTime)
                                    {{ \Carbon\Carbon::parse($selectedTime)->format('H:i') }} - {{ \Carbon\Carbon::parse($selectedTime)->addMinutes($selectedDuration)->format('H:i') }}
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Duración:</span>
                            <span class="font-medium text-slate-800 dark:text-slate-200">{{ $selectedDuration }} minutos</span>
                        </div>
                    </div>

                    @if($errors->has('selectedDoctorId'))
                        <div class="text-rose-500 text-sm mb-4">{{ $errors->first('selectedDoctorId') }}</div>
                    @endif
                    @if($errors->has('selectedDate'))
                        <div class="text-rose-500 text-sm mb-4">{{ $errors->first('selectedDate') }}</div>
                    @endif

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Paciente</label>
                            <select wire:model="patient_id" class="form-select w-full rounded-md border-slate-300 shadow-sm text-sm">
                                <option value="">Seleccione un paciente</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->user->name ?? 'Sin nombre' }}</option>
                                @endforeach
                            </select>
                            @error('patient_id') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Motivo de la cita</label>
                            <textarea wire:model="reason" rows="3" class="form-textarea w-full rounded-md border-slate-300 shadow-sm text-sm" placeholder="Ingrese el motivo o síntomas principales de la cita"></textarea>
                            @error('reason') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <button wire:click="confirmAppointment" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 rounded-md text-sm mt-4 transition duration-150 shadow">
                            Confirmar cita
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
