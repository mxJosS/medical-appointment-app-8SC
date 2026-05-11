<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DoctorDailyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointments;
    public $date;
    public $doctor;

    /**
     * Create a new message instance.
     */
    public function __construct($doctor, $appointments, $date)
    {
        $this->doctor = $doctor;
        $this->appointments = $appointments;
        $this->date = $date;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Agenda del Día - Dr. ' . $this->doctor->name . ' (' . $this->date . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.doctor_daily_report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
