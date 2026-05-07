<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class ConsultationManager extends Component
{
    public \App\Models\Appointment $appointment;
    public $activeTab = 'consulta';
    public $diagnosis;
    public $treatment;
    public $notes;
    public $medicines = [];
    public $newMedicine = '';
    public $newDosis = '';
    public $newFrecuencia = '';
    public $showHistoryModal = false;
    public $showMedicalHistoryModal = false;

    public function mount(\App\Models\Appointment $appointment)
    {
        $this->appointment = $appointment;
        // Init with one empty medicine if needed, or leave empty
    }

    public function addMedicine()
    {
        if (trim($this->newMedicine) !== '') {
            $this->medicines[] = [
                'medicamento' => $this->newMedicine,
                'dosis' => $this->newDosis,
                'frecuencia' => $this->newFrecuencia,
            ];
            $this->newMedicine = '';
            $this->newDosis = '';
            $this->newFrecuencia = '';
        }
    }

    public function removeMedicine($index)
    {
        unset($this->medicines[$index]);
        $this->medicines = array_values($this->medicines);
    }

    public function saveConsultation()
    {
        $this->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'required|string',
        ], [
            'diagnosis.required' => 'El campo Diagnóstico es obligatorio.',
            'treatment.required' => 'El campo Tratamiento es obligatorio.',
            'notes.required' => 'El campo Notas Adicionales es obligatorio.',
        ]);

        $this->appointment->update([
            'diagnosis' => $this->diagnosis,
            'treatment' => $this->treatment,
            'notes' => $this->notes,
            'status' => 0 // 0 for completed
        ]);
        
        foreach ($this->medicines as $med) {
            \App\Models\Prescription::create([
                'appointment_id' => $this->appointment->id,
                'medicine_name' => $med['medicamento'],
                'dosis' => $med['dosis'],
                'frecuencia' => $med['frecuencia'],
            ]);
        }
        
        session()->flash('success', 'Consulta finalizada exitosamente.');
        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        // Fetch past consultations (appointments with status 0 or before today) for the same patient
        $pastConsultations = \App\Models\Appointment::where('patient_id', $this->appointment->patient_id)
            ->where('id', '!=', $this->appointment->id)
            ->where('status', 0) // Assuming 0 is completed
            ->orderBy('date', 'desc')
            ->get();

        return view('livewire.admin.consultation-manager', [
            'pastConsultations' => $pastConsultations
        ])->layout('layouts.admin', [
            'title' => 'Atender Cita',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
                ['name' => 'Citas', 'href' => route('admin.appointments.index')],
                ['name' => 'Atender Consulta']
            ]
        ]);
    }
}
