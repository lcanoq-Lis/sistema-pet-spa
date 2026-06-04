<?php

namespace App\Mail;

use App\Models\Pago;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PagoRegistradoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pago $pago) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Pago recibido — Pet Spa',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pago_registrado',
        );
    }
}
