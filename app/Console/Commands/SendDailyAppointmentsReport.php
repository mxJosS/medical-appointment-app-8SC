<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AdminDailyReportMail;
use App\Mail\DoctorDailyReportMail;

class SendDailyAppointmentsReport extends Command
{
    protected $signature = 'vitalia:daily-report';
    protected $description = 'Envía un reporte diario de citas a los administradores y doctores';

    public function handle()
    {
        $today = now()->toDateString();
        $appointments = Appointment::where('date', $today)
            ->where('status', 1)
            ->with(['patient.user', 'doctor'])
            ->get();

        if ($appointments->isEmpty()) {
            $this->info("No hay citas programadas para hoy ($today).");
            return;
        }

        // 1. Reporte para el Administrador (todas las citas)
        $this->sendAdminReport($appointments, $today);

        // 2. Reporte para cada Doctor (solo sus citas)
        $doctors = User::whereHas('doctor')->get();
        foreach ($doctors as $doctor) {
            $doctorAppointments = $appointments->where('doctor_id', $doctor->id);
            if ($doctorAppointments->isNotEmpty()) {
                $this->sendDoctorReport($doctor, $doctorAppointments, $today);
            }
        }

        $this->info("Reportes diarios enviados correctamente.");
    }

    protected function sendAdminReport($appointments, $date)
    {
        try {
            // Obtener administradores del sistema
            $admins = User::role('Administrador')->get();
            $adminEmails = $admins->pluck('email')->toArray();

            if (empty($adminEmails)) {
                $adminEmails = [config('mail.from.address')];
            }

            Mail::to($adminEmails)->send(new AdminDailyReportMail($appointments, $date));
            Log::info("Reporte Diario Admin enviado a: " . implode(', ', $adminEmails));
        } catch (\Exception $e) {
            Log::error("Error enviando reporte Admin: " . $e->getMessage());
        }
    }

    protected function sendDoctorReport($doctor, $appointments, $date)
    {
        try {
            Mail::to($doctor->email)->send(new DoctorDailyReportMail($doctor, $appointments, $date));
            Log::info("Reporte Diario Doctor {$doctor->name} enviado ($date)");
        } catch (\Exception $e) {
            Log::error("Error enviando reporte Doctor {$doctor->name}: " . $e->getMessage());
        }
    }
}
