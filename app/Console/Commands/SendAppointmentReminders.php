<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\TwilioService;

class SendAppointmentReminders extends Command
{
    protected $signature = 'vitalia:send-reminders';
    protected $description = 'Envía recordatorios de WhatsApp para citas en exactamente 24 horas';

    public function handle()
    {
        $targetDate = now()->addDay()->toDateString();
        $currentTime = now()->toTimeString();

        // Buscamos citas para mañana, cuya hora ya pasó hoy (exactamente 24h antes o menos) 
        // y que no hayan recibido recordatorio aún.
        $appointments = Appointment::where('date', $targetDate)
            ->where('start_time', '<=', $currentTime)
            ->where('status', 1) 
            ->where('reminder_sent', false)
            ->with(['patient.user'])
            ->get();

        if ($appointments->isEmpty()) {
            return;
        }

        foreach ($appointments as $appointment) {
            if ($this->sendWhatsAppReminder($appointment)) {
                $appointment->update(['reminder_sent' => true]);
            }
        }

        $this->info("Recordatorios procesados: " . $appointments->count());
    }

    protected function sendWhatsAppReminder(Appointment $appointment)
    {
        $user = $appointment->patient->user;
        $phone = $user->phone;

        if (!$phone) {
            return false;
        }

        // Limpiar y formatear para Twilio
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        if (!str_starts_with($phone, '+')) {
            $phone = strlen($phone) === 10 ? '+521' . $phone : '+' . $phone;
        }

        $date = \Carbon\Carbon::parse($appointment->date)->locale('es')->isoFormat('D [de] MMMM');
        $time = \Carbon\Carbon::parse($appointment->start_time)->format('h:i A');
        $message = "⏰ Recordatorio Vitalia: Hola {$user->name}, tienes una cita *mañana {$date}* a las *{$time}*. ¡No olvides asistir!";

        try {
            $twilio = new TwilioService();
            $success = $twilio->sendMessage($phone, $message);

            if ($success) {
                Log::info("Recordatorio WhatsApp enviado vía Twilio:", [
                    'to' => $phone,
                    'appointment_id' => $appointment->id
                ]);
            }
            return $success;
        } catch (\Exception $e) {
            Log::error("Error enviando recordatorio WhatsApp: " . $e->getMessage());
            return false;
        }
    }
}
