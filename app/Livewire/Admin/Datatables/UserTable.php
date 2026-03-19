<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
class UserTable extends DataTableComponent
{

    // protected $model = User::class;
    //este metodo define el modelo
    public function builder(): Builder
    {
        return User::query()
        ->with('roles'); // Cargar la relación de roles para evitar consultas adicionales
    }
    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nombre", "name")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Número de ID", "id_number")
                ->sortable(),
            Column::make("Teléfono", "phone")
                ->sortable(),
            Column::make("Rol", "roles")
                ->label(function($row) {
                    return $row->roles->first()->name ?? 'Sin rol'; // Mostrar el nombre del primer rol o 'Sin rol' si no tiene
                }),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view('admin.users.actions', ['user' => $row]);
                })
        ];
    }
}
