<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Notification extends Mailable
{
    use Queueable, SerializesModels;

    public string $title;
    public string $body;
    public string $link;
    public string $unsubscribeLink;

    /**
     * Create a new message instance.
     */
    public function __construct(string $title, string $body, string $link, string $unsubscribeLink)
    {
        $this->title = $title;
        $this->body = $body;
        $this->link = $link;
        $this->unsubscribeLink = $unsubscribeLink;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->title)->view('emails.notification');
    }
}
