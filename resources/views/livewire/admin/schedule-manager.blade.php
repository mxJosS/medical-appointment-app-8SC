<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Horarios de {{ $doctor->user->name }}</h1>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <button wire:click="saveSchedule" class="btn bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg px-4 py-2 font-medium">
                Guardar horario
            </button>
        </div>
    </div>



    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-100 mb-6">Gestor de horarios</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-500 dark:text-slate-400">
                    <thead class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-transparent border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="py-3 px-4 font-semibold">DÍA/HORA</th>
                            @foreach($days as $day)
                                <th class="py-3 px-4 font-semibold text-center">{{ $day }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach($timeBlocks as $hour => $intervals)
                        <tr>
                            <!-- Hora block label -->
                            <td class="py-4 px-4 align-top w-48">
                                <div class="flex items-center">
                                    <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600" disabled>
                                    <label class="ml-2 font-semibold text-slate-800 dark:text-slate-100">{{ $hour }}</label>
                                </div>
                            </td>
                            
                            @foreach($days as $day)
                            <td class="py-4 px-4 align-top">
                                <div class="flex flex-col space-y-2">
                                    <!-- Todos toggle -->
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:click="toggleAll('{{ $day }}', '{{ $hour }}')" class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                                        <span class="ml-2 text-sm text-slate-700 dark:text-slate-300">Todos</span>
                                    </label>
                                    
                                    <!-- Intervals -->
                                    @foreach($intervals as $interval)
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model="schedule.{{ $day }}.{{ $hour }}.{{ $interval }}" class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                                        <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">{{ $interval }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>
