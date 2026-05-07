<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient.user', 'doctor'])->orderBy('date', 'desc')->orderBy('start_time', 'desc')->paginate(10);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        // Assuming patients can be retrieved by looking at the patients table,
        // and we want to show their user's name.
        $patients = Patient::with('user')->get();
        // Since there is no Doctor model or role defined, we fetch all users or users with some condition.
        // We'll just fetch all users as potential doctors for now.
        $doctors = User::all();
        
        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'nullable|string',
        ]);

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => 15, // default
            'reason' => $request->reason,
            'status' => 1,
        ]);

        return redirect()->route('admin.appointments.index')->with('success', 'Cita registrada exitosamente.');
    }

    public function show(string $id) { }
    
    public function edit(Appointment $appointment)
    {
        $patients = Patient::with('user')->get();
        $doctors = User::all();
        
        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'nullable|string',
        ]);

        $appointment->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'reason' => $request->reason,
        ]);

        return redirect()->route('admin.appointments.index')->with('success', 'Cita actualizada exitosamente.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('admin.appointments.index')->with('success', 'Cita eliminada exitosamente.');
    }
}
