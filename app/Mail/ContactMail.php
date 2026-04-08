<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Les données du formulaire

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->to(env('MAIL_TO_ADDRESS'))
            ->replyTo($this->data['email'], $this->data['name'])
            ->subject('Nouveau message depuis le formulaire de contact')
            ->view('emails.contact');
    }
}
