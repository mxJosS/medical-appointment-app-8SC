<?php

namespace App\Listeners;

use App\Events\AppointmentBooked;
use App\Mail\AppointmentBookedMail;
use App\Services\TwilioService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendAppointmentNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(AppointmentBooked $event): void
    {
        $appointment = $event->appointment;
        $appointment->load(['patient.user', 'doctor']);

        try {
            // 1. Generación de PDF en memoria
            $pdf = Pdf::loadView('pdf.appointment', compact('appointment'));
            $pdfContent = $pdf->output();

            // 2. Envío de Correo (Paciente y Doctor)
            Mail::to($appointment->patient->user->email)->send(new AppointmentBookedMail($appointment, $pdfContent, $appointment->patient->user->name));
            Mail::to($appointment->doctor->email)->send(new AppointmentBookedMail($appointment, $pdfContent, "Dr. {$appointment->doctor->name}"));
            
            Log::info("Notificaciones por correo enviadas para cita ID: {$appointment->id}");
        } catch (\Exception $e) {
            Log::error("Error enviando correos de cita: " . $e->getMessage());
        }

        // 3. Envío de WhatsApp
        $this->sendWhatsAppConfirmation($appointment);
    }

    protected function sendWhatsAppConfirmation($appointment)
    {
        $user = $appointment->patient->user;
        $phone = $user->phone;

        if (!$phone) {
            Log::warning("Paciente sin teléfono para cita ID: {$appointment->id}");
            return;
        }

        // Limpiar el teléfono (quitar espacios, guiones, paréntesis)
        $phone = preg_replace('/[^0-9+]/', '', $phone);

        // Si ya tiene + respetarlo, si no, agregar código de México (+521 para móviles)
        if (!str_starts_with($phone, '+')) {
            // Número de 10 dígitos mexicano → +521XXXXXXXXXX
            if (strlen($phone) === 10) {
                $phone = '+521' . $phone;
            } else {
                $phone = '+' . $phone;
            }
        }

        $date = \Carbon\Carbon::parse($appointment->date)->locale('es')->isoFormat('D [de] MMMM [de] YYYY');
        $time = \Carbon\Carbon::parse($appointment->start_time)->format('h:i A');
        $message = "✅ Hola {$user->name}, tu cita en *Vitalia* ha sido confirmada.\n\n📅 Fecha: {$date}\n⏰ Hora: {$time}\n\n¡Te esperamos! Si necesitas cancelar, contáctanos con anticipación.";

        try {
            $twilio = new TwilioService();
            $result = $twilio->sendMessage($phone, $message);

            if ($result) {
                Log::info("WhatsApp de confirmación enviado a {$phone} para cita ID: {$appointment->id}");
            } else {
                Log::error("Fallo al enviar WhatsApp a {$phone} para cita ID: {$appointment->id}");
            }
        } catch (\Exception $e) {
            Log::error("Error enviando WhatsApp de confirmación: " . $e->getMessage());
        }
    }
}
