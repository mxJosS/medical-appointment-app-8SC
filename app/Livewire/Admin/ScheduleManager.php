<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class ScheduleManager extends Component
{
    public \App\Models\Doctor $doctor;

    public $schedule = [];
    public $days = ['LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES'];
    public $timeBlocks = [
        '08:00:00' => ['08:00 - 08:15', '08:15 - 08:30', '08:30 - 08:45', '08:45 - 09:00'],
        '09:00:00' => ['09:00 - 09:15', '09:15 - 09:30', '09:30 - 09:45', '09:45 - 10:00'],
        '10:00:00' => ['10:00 - 10:15', '10:15 - 10:30', '10:30 - 10:45', '10:45 - 11:00'],
        '11:00:00' => ['11:00 - 11:15', '11:15 - 11:30', '11:30 - 11:45', '11:45 - 12:00']
    ];

    public function mount(\App\Models\Doctor $doctor)
    {
        $this->doctor = $doctor;
        $savedSchedule = $doctor->schedule ?? [];

        foreach ($this->days as $day) {
            foreach ($this->timeBlocks as $hour => $intervals) {
                foreach ($intervals as $interval) {
                    $this->schedule[$day][$hour][$interval] = $savedSchedule[$day][$hour][$interval] ?? false;
                }
            }
        }
    }

    public function toggleAll($day, $hour)
    {
        // Toggle all intervals for a specific day and hour block
        $currentState = $this->schedule[$day][$hour][$this->timeBlocks[$hour][0]];
        foreach ($this->timeBlocks[$hour] as $interval) {
            $this->schedule[$day][$hour][$interval] = !$currentState;
        }
    }

    public function saveSchedule()
    {
        $this->doctor->update([
            'schedule' => $this->schedule
        ]);

        $this->dispatch('swal', title: '¡Éxito!', text: 'Horarios guardados exitosamente.', icon: 'success');
    }

    public function render()
    {
        return view('livewire.admin.schedule-manager')->layout('layouts.admin', [
            'title' => 'Horarios',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
                ['name' => 'Doctores', 'href' => route('admin.doctors.index')],
                ['name' => 'Horarios']
            ]
        ]);
    }
}
