<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        Role::create(['name' => $request->name]);

        session()->flash('swal', [
            'icon' => 'success', 
            'title' => 'Rol creado correctamente',
            'text' => 'El rol se ha creado correctamente'
        ]);

        return redirect()->route('admin.roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // Validar los datos del formulario y que excluya la fila que editamos
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        // Actualizar el rol, osea si pasa la validacion editara el rol
        $role->update(['name' => $request->name]);

        // Redirigir a la vista de index con el flash para SweetAlert
        return redirect()->route('admin.roles.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Rol actualizado correctamente',
            'text' => 'El rol se ha modificado correctamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
            //Borrar el elemento
            $role->delete();

            session()->flash('swal', [
                'icon' => 'success',
                'title' => 'Rol eliminado correctamente',
                'text' => 'El rol se ha eliminado correctamente'
            ]);
            return redirect()->route('admin.roles.index');
            
    }

}
