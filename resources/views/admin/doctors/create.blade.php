<x-admin-layout title="Nuevo Doctor" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Doctores', 'href' => route('admin.doctors.index')],
    ['name' => 'Nuevo']
]">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Registrar Nuevo Doctor</h1>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
            <div class="p-6">
                <form action="{{ route('admin.doctors.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nombre completo <span class="text-rose-500">*</span></label>
                            <input name="name" type="text" value="{{ old('name') }}" class="form-input w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300" required />
                            @error('name') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email <span class="text-rose-500">*</span></label>
                            <input name="email" type="email" value="{{ old('email') }}" class="form-input w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300" required />
                            @error('email') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- DNI -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">DNI <span class="text-rose-500">*</span></label>
                            <input name="id_number" type="text" value="{{ old('id_number') }}" class="form-input w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300" required />
                            @error('id_number') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Teléfono <span class="text-rose-500">*</span></label>
                            <input name="phone" type="text" value="{{ old('phone') }}" class="form-input w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300" required />
                            @error('phone') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Especialidad -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Especialidad <span class="text-rose-500">*</span></label>
                            <input name="specialty" type="text" value="{{ old('specialty') }}" class="form-input w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300" required />
                            @error('specialty') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Contraseña <span class="text-rose-500">*</span></label>
                            <input name="password" type="password" class="form-input w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300" required />
                            @error('password') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Confirmar Contraseña <span class="text-rose-500">*</span></label>
                            <input name="password_confirmation" type="password" class="form-input w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-slate-300" required />
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.doctors.index') }}" class="btn border-slate-200 hover:border-slate-300 text-slate-600 rounded-lg px-4 py-2 font-medium">Cancelar</a>
                        <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg px-4 py-2 font-medium">Guardar Doctor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
