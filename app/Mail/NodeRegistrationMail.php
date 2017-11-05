<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NodeRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $node;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($node)
    {
        $this->node = $node;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.node_registration')
                    ->text('emails.node_registration_plain');
    }
}
