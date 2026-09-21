<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Invitation $invitation)
    {
        //
    }

    public function build(): self
    {
        return $this->subject('Bakery Admin Invitation')
            ->view('emails.admin_invitation')
            ->with([
                'token' => $this->invitation->token,
                'email' => $this->invitation->email,
            ]);
    }
}
