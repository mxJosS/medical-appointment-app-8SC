<?php
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;

$p = Patient::first();
$d = User::whereHas('doctor')->first();

if ($p && $d) {
    Appointment::create([
        'patient_id' => $p->id,
        'doctor_id' => $d->id,
        'date' => now()->addDay()->toDateString(),
        'start_time' => '08:00:00',
        'end_time' => '08:30:00',
        'duration' => 30,
        'reason' => 'Test Reminder',
        'status' => 1,
    ]);
    echo "Appointment created for tomorrow.";
} else {
    echo "Patient or Doctor not found.";
}
