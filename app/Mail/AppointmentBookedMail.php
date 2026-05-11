<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentBookedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $pdfContent;
    public $recipientName;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, $pdfContent, $recipientName)
    {
        $this->appointment = $appointment;
        $this->pdfContent = $pdfContent;
        $this->recipientName = $recipientName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmación de Cita Médica - Vitalia',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment_booked',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, 'Cita_Vitalia.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
