<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * મેસેજનું સબ્જેક્ટ સેટ કરવા માટે
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Registration - My Home PGMS',
        );
    }

    /**
     * સાચું બ્લેડ વ્યુ સેટ કરવા માટે
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.otp', // અહીં ભૂલ હતી, 'view.name' કાઢીને 'emails.otp' કર્યું
        );
    }

    public function attachments(): array
    {
        return [];
    }
}