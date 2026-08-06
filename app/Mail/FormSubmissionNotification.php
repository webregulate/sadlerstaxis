<?php

namespace App\Mail;

use App\Models\Form as FormModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormSubmissionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public FormModel $form,
        public array $data,
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->form->renderTemplate($this->form->subject_template, $this->data)
            ?: 'New submission: '.$this->form->name;

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.form-submission',
            with: [
                'formName' => $this->form->name,
                'bodyMessage' => $this->form->renderTemplate($this->form->message_template, $this->data),
                'data' => $this->data,
            ],
        );
    }
}
