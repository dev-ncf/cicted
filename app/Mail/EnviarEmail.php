<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnviarEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $nome;
    public $categoria;
    public $email;
    public $senha;

    /**
     * Create a new message instance.
     */
    public function __construct($nome,$categoria,$email,$senha)
    {
        //
         $this->nome = $nome;
         $this->categoria = $categoria;
         $this->email = $email;
         $this->senha = $senha;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email de confirmacao',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if($this->email){

            return new Content(
                view: 'email',
            );
        }else{
            return new Content(
                view: 'email2',
            );
        }
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
