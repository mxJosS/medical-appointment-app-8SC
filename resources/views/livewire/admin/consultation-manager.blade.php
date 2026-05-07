<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Atención de Cita: {{ $appointment->patient->user->name ?? 'N/A' }}</h1>
            <p class="text-slate-500 text-sm mt-1">Fecha: {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }} | Hora: {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</p>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Modal Buttons -->
            <button wire:click="$set('showMedicalHistoryModal', true)" class="btn bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-slate-600 dark:text-slate-300 rounded-lg px-4 py-2 font-medium">
                <i class="fa-solid fa-file-medical mr-2 text-indigo-500"></i>Ver Historia
            </button>
            <button wire:click="$set('showHistoryModal', true)" class="btn bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-slate-600 dark:text-slate-300 rounded-lg px-4 py-2 font-medium">
                <i class="fa-solid fa-clock-rotate-left mr-2 text-indigo-500"></i>Consultas Anteriores
            </button>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
        <!-- Tabs -->
        <div class="border-b border-slate-200 dark:border-slate-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-slate-500 dark:text-slate-400">
                <li class="mr-2">
                    <button wire:click="$set('activeTab', 'consulta')" class="inline-flex p-4 border-b-2 rounded-t-lg {{ $activeTab === 'consulta' ? 'text-indigo-600 border-indigo-600 dark:text-indigo-500 dark:border-indigo-500' : 'border-transparent hover:text-slate-600 hover:border-slate-300 dark:hover:text-slate-300' }}">
                        <i class="fa-solid fa-stethoscope mr-2 mt-0.5"></i> Consulta
                    </button>
                </li>
                <li class="mr-2">
                    <button wire:click="$set('activeTab', 'receta')" class="inline-flex p-4 border-b-2 rounded-t-lg {{ $activeTab === 'receta' ? 'text-indigo-600 border-indigo-600 dark:text-indigo-500 dark:border-indigo-500' : 'border-transparent hover:text-slate-600 hover:border-slate-300 dark:hover:text-slate-300' }}">
                        <i class="fa-solid fa-pills mr-2 mt-0.5"></i> Receta Médica
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content: Consulta -->
        <div class="p-6 {{ $activeTab === 'consulta' ? '' : 'hidden' }}">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Diagnóstico</label>
                    <textarea wire:model="diagnosis" rows="3" class="form-textarea w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300" placeholder="Ej. Faringitis aguda..."></textarea>
                    @error('diagnosis') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tratamiento (Instrucciones Generales)</label>
                    <textarea wire:model="treatment" rows="3" class="form-textarea w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300" placeholder="Ej. Reposo por 3 días..."></textarea>
                    @error('treatment') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Notas Adicionales</label>
                    <textarea wire:model="notes" rows="2" class="form-textarea w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300"></textarea>
                    @error('notes') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Tab Content: Receta -->
        <div class="p-6 {{ $activeTab === 'receta' ? '' : 'hidden' }}">
            <div class="bg-slate-50 dark:bg-slate-900/20 p-4 rounded-lg border border-slate-200 dark:border-slate-700 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-5 relative">
                        <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Medicamento</label>
                        <div class="relative flex items-center">
                            <input wire:model.defer="newMedicine" type="text" class="form-input w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300 pr-8" placeholder="Ej. Amoxicilina 500mg">
                            <button type="button" wire:click="$set('newMedicine', '')" class="absolute right-2 text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                    <div class="md:col-span-3 relative">
                        <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Dosis</label>
                        <div class="relative flex items-center">
                            <input wire:model.defer="newDosis" type="text" class="form-input w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300 pr-8" placeholder="Ej. 1 cada 8 horas">
                            <button type="button" wire:click="$set('newDosis', '')" class="absolute right-2 text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                    <div class="md:col-span-4 relative">
                        <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Frecuencia / Duración</label>
                        <div class="relative flex items-center">
                            <input wire:model.defer="newFrecuencia" type="text" class="form-input w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300 pr-8" placeholder="Ej: cada 8 horas por 7 días" @keydown.enter="addMedicine">
                            <button type="button" wire:click="$set('newFrecuencia', '')" class="absolute right-2 text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button wire:click="addMedicine" class="btn bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 text-slate-600 dark:text-slate-300 rounded px-4 py-2 text-sm font-medium">
                        <i class="fa-solid fa-plus mr-2"></i> Añadir Medicamento
                    </button>
                </div>
            </div>

            @if(count($medicines) > 0)
            <div class="space-y-3">
                @foreach($medicines as $index => $medicine)
                <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 w-full mr-4 items-center">
                        <div class="md:col-span-5 font-medium text-slate-800 dark:text-slate-100">{{ $medicine['medicamento'] }}</div>
                        <div class="md:col-span-3 text-sm text-slate-500">{{ $medicine['dosis'] }}</div>
                        <div class="md:col-span-4 text-sm text-slate-500">{{ $medicine['frecuencia'] }}</div>
                    </div>
                    <button wire:click="removeMedicine({{ $index }})" class="w-8 h-8 rounded bg-rose-500 hover:bg-rose-600 text-white flex items-center justify-center flex-shrink-0 transition-colors">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
                @endforeach
            </div>
            @endif

            <div class="mt-8 flex justify-end">
                <button wire:click="saveConsultation" class="btn bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg px-6 py-2 font-medium shadow-sm">
                    <i class="fa-solid fa-save mr-2"></i>Guardar Consulta
                </button>
            </div>
        </div>
    </div>

    <!-- Historial Modal -->
    @if($showHistoryModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-slate-900/50 backdrop-blur-sm">
        <div class="relative bg-white dark:bg-slate-800 w-full max-w-3xl rounded-lg shadow-lg max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-5 border-b border-slate-200 dark:border-slate-700">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">
                    Historial Clínico: {{ $appointment->patient->user->name ?? 'N/A' }}
                </h3>
                <button wire:click="$set('showHistoryModal', false)" class="text-slate-400 hover:text-slate-500 dark:hover:text-slate-300">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-5 overflow-y-auto">
                @if($pastConsultations->isEmpty())
                    <p class="text-slate-500 dark:text-slate-400 text-center py-4">No hay consultas anteriores registradas para este paciente.</p>
                @else
                    <div class="space-y-4">
                        @foreach($pastConsultations as $consult)
                        <div class="bg-white dark:bg-slate-800 p-5 rounded-lg border border-indigo-200 dark:border-indigo-500 shadow-sm relative">
                            <div class="flex justify-between items-start mb-4">
                                <div class="text-indigo-600 dark:text-indigo-400 font-semibold flex items-center">
                                    <i class="fa-regular fa-calendar mr-2"></i>
                                    {{ \Carbon\Carbon::parse($consult->date)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($consult->start_time)->format('H:i') }}
                                </div>
                                <button class="btn border-indigo-200 hover:border-indigo-300 text-indigo-500 rounded px-3 py-1 text-sm font-medium">
                                    Consultar Detalle
                                </button>
                            </div>
                            <div class="mb-3">
                                <span class="text-sm text-slate-500 dark:text-slate-400">Atendido por: Dr(a). {{ $consult->doctor->name ?? 'N/A' }}</span>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-900/50 p-4 rounded text-sm text-slate-700 dark:text-slate-300">
                                <p class="mb-1"><strong class="text-slate-900 dark:text-slate-100">Motivo de Consulta:</strong> {{ $consult->reason ?? 'Sin especificar' }}</p>
                                @if($consult->diagnosis)
                                    <p class="mb-1"><strong class="text-slate-900 dark:text-slate-100">Diagnóstico:</strong> {{ $consult->diagnosis }}</p>
                                @endif
                                @if($consult->treatment)
                                    <p class="mb-1"><strong class="text-slate-900 dark:text-slate-100">Tratamiento:</strong> {{ $consult->treatment }}</p>
                                @endif
                                @if($consult->notes)
                                    <p class="mb-1"><strong class="text-slate-900 dark:text-slate-100">Notas:</strong> {{ $consult->notes }}</p>
                                @endif
                                
                                @php
                                    $prescriptions = \App\Models\Prescription::where('appointment_id', $consult->id)->get();
                                @endphp
                                @if($prescriptions->isNotEmpty())
                                    <div class="mt-3 pt-3 border-t border-slate-200 dark:border-slate-700/50">
                                        <strong class="text-slate-900 dark:text-slate-100 block mb-2">Receta Médica:</strong>
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach($prescriptions as $pres)
                                                <li>{{ $pres->medicine_name }} - {{ $pres->dosis }} ({{ $pres->frecuencia }})</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <!-- Modal Footer -->
            <div class="flex justify-end p-5 border-t border-slate-200 dark:border-slate-700">
                <button wire:click="$set('showHistoryModal', false)" class="btn bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-slate-600 dark:text-slate-300 rounded-lg px-4 py-2 font-medium">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Ver Historia Modal -->
    @if($showMedicalHistoryModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-slate-900/50 backdrop-blur-sm">
        <div class="relative bg-white dark:bg-slate-800 w-full max-w-3xl rounded-lg shadow-lg max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-5 border-b border-slate-200 dark:border-slate-700">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">
                    Historia Médica del Paciente: {{ $appointment->patient->user->name ?? 'N/A' }}
                </h3>
                <button wire:click="$set('showMedicalHistoryModal', false)" class="text-slate-400 hover:text-slate-500 dark:hover:text-slate-300">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-5 overflow-y-auto">
                <div class="space-y-6">
                    <div>
                        <h4 class="text-sm font-semibold text-slate-500 uppercase mb-2">Datos Generales</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm text-slate-700 dark:text-slate-300">
                            <div><strong class="text-slate-800 dark:text-slate-100">Tipo de Sangre:</strong> {{ $appointment->patient->blood_type->name ?? 'N/A' }}</div>
                            <div><strong class="text-slate-800 dark:text-slate-100">Alergias:</strong> {{ $appointment->patient->allergies ?? 'Ninguna registrada' }}</div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-500 uppercase mb-2">Enfermedades Crónicas</h4>
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-3 rounded text-sm text-slate-700 dark:text-slate-300">
                            {{ $appointment->patient->chronic_conditions ?? 'Ninguna registrada' }}
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-500 uppercase mb-2">Antecedentes Quirúrgicos</h4>
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-3 rounded text-sm text-slate-700 dark:text-slate-300">
                            {{ $appointment->patient->surgical_history ?? 'Ninguno registrado' }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="flex justify-end p-5 border-t border-slate-200 dark:border-slate-700">
                <button wire:click="$set('showMedicalHistoryModal', false)" class="btn bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-slate-600 dark:text-slate-300 rounded-lg px-4 py-2 font-medium">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
