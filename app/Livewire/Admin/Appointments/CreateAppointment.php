<?php

namespace App\Livewire\Admin\Appointments;

use Livewire\Component;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Carbon\Carbon;

class CreateAppointment extends Component
{
    public $searchDate;
    public $searchTimeRange; 
    public $searchSpecialty;

    public $availableDoctors = [];

    // Selected Appointment Data
    public $selectedDoctorId = null;
    public $selectedDoctorName = null;
    public $selectedDate = null;
    public $selectedTime = null; 
    public $selectedDuration = 15; // in minutes
    
    public $patient_id = '';
    public $reason = '';

    public function mount()
    {
        $this->searchDate = Carbon::now()->format('Y-m-d');
        // Initial search
        $this->searchAvailability();
    }

    public function searchAvailability()
    {
        $query = Doctor::with('user');
        
        if ($this->searchSpecialty) {
            $query->where('specialty', 'like', '%' . $this->searchSpecialty . '%');
        }
        
        $doctors = $query->get();
        
        $this->availableDoctors = [];
        
        foreach ($doctors as $doctor) {
            // Generating some mock time slots for the demo
            $slots = ['08:00:00', '08:30:00', '09:00:00', '09:30:00', '10:00:00', '10:30:00'];
            
            // Filter out taken slots
            $takenSlots = Appointment::where('doctor_id', $doctor->user_id)
                ->where('date', $this->searchDate)
                ->pluck('start_time')->toArray();
                
            $availableSlots = array_filter($slots, function($slot) use ($takenSlots) {
                // Ensure format matches, e.g., '08:00:00'
                $formattedSlot = strlen($slot) == 5 ? $slot . ':00' : $slot;
                return !in_array($formattedSlot, $takenSlots);
            });
            
            if (count($availableSlots) > 0) {
                $this->availableDoctors[] = [
                    'id' => $doctor->user_id,
                    'name' => $doctor->user->name ?? 'Dr.',
                    'specialty' => $doctor->specialty,
                    'slots' => array_values($availableSlots),
                    'initials' => collect(explode(' ', $doctor->user->name ?? 'D R'))->map(fn($n) => substr($n, 0, 1))->take(2)->implode('')
                ];
            }
        }
        
        // Reset selection when searching
        $this->selectedDoctorId = null;
        $this->selectedDoctorName = null;
        $this->selectedDate = null;
        $this->selectedTime = null;
    }

    public function selectSlot($doctorId, $doctorName, $time)
    {
        if ($this->selectedDoctorId === $doctorId && $this->selectedTime === $time) {
            $this->selectedDoctorId = null;
            $this->selectedDoctorName = null;
            $this->selectedDate = null;
            $this->selectedTime = null;
            return;
        }

        $this->selectedDoctorId = $doctorId;
        $this->selectedDoctorName = $doctorName;
        $this->selectedDate = $this->searchDate;
        $this->selectedTime = $time;
    }

    public function confirmAppointment()
    {
        $this->validate([
            'patient_id' => 'required',
            'selectedDoctorId' => 'required',
            'selectedDate' => 'required|date|after_or_equal:today',
            'selectedTime' => 'required',
            'reason' => 'required|string',
        ], [
            'patient_id.required' => 'Debe seleccionar un paciente.',
            'selectedDoctorId.required' => 'Debe seleccionar un horario disponible.',
            'selectedDate.after_or_equal' => 'La fecha de la cita no puede ser en el pasado.',
            'reason.required' => 'Debe ingresar el motivo de la cita.',
        ]);

        $endTime = Carbon::parse($this->selectedDate . ' ' . $this->selectedTime)->addMinutes($this->selectedDuration)->format('H:i:s');

        Appointment::create([
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->selectedDoctorId,
            'date' => $this->selectedDate,
            'start_time' => $this->selectedTime,
            'end_time' => $endTime,
            'duration' => $this->selectedDuration,
            'reason' => $this->reason,
            'status' => 1,
        ]);

        session()->flash('success', 'Cita registrada exitosamente.');
        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        $patients = Patient::with('user')->get();
        return view('livewire.admin.appointments.create-appointment', compact('patients'));
    }
}
