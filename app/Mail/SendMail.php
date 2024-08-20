<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $web_content, $title, $fromEmail, $from_address, $filepath;
    /**
     * Create a new message instance.
     */
    public function __construct($web_content, $title, $from, $from_address=null, $filepath=null)
    {
        $this->web_content = $web_content;
        $this->title = $title;
        $this->fromEmail = $from;
        $this->from_address = $from_address;
        $this->filepath = $filepath;
    }

    
    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: $this->from_address ?? env('MAIL_FROM_ADDRESS', "dangaura.tejendra.123@gmail.com"),
            subject: $this->title,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            html: $this->web_content,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    
    public function build()
    {
        $email =  $this->subject($this->title)
                    ->html($this->web_content);

            if ($this->filepath) {
                $email->attach($this->filepath, [
                    'as' => 'interview-attend.png',  // Optional: specify a name for the attachment
                    'mime' => 'image/png'  // Optional: specify the MIME type
                ]);
            }

                    // or use ->text('This is your plain text content');
    }
}
