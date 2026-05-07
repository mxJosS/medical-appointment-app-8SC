<a href="{{ route('admin.appointments.consultation', $appointment->id) }}" class="text-slate-400 hover:text-indigo-500 rounded-full bg-slate-100 dark:bg-slate-800 p-2 inline-flex items-center justify-center transition-colors">
    <span class="sr-only">Atender Cita</span>
    <i class="fa-solid fa-stethoscope text-lg"></i>
</a>
<a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="text-slate-400 hover:text-slate-500 rounded-full bg-slate-100 dark:bg-slate-800 p-2 inline-flex items-center justify-center transition-colors ml-1">
    <span class="sr-only">Editar</span>
    <i class="fa-solid fa-pen"></i>
</a>
<form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" class="inline-block delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-slate-400 hover:text-rose-500 rounded-full bg-slate-100 dark:bg-slate-800 p-2 inline-flex items-center justify-center transition-colors ml-1 btn-delete">
        <span class="sr-only">Eliminar</span>
        <i class="fa-solid fa-trash"></i>
    </button>
</form>
