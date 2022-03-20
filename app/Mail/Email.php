<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Nova senha - Sistema de Gestão de Frota');
        $this->to($this->data['email'], 'Franco Engenharia');
        return $this->view('mail.email',[
            'login' => $this->data['email'],
            'senha' => $this->data['senha']
        ]);
    }
}
