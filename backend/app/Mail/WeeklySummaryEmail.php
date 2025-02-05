<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

final class WeeklySummaryEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public User $user, public Collection $transactions) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('finance@example.com', 'Finance'),
            subject: 'Weekly Summary Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.weeklySummaryEmailTemplate',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView(
            view: 'pdfs.weeklySummary',
            data: ['transactions' => $this->transactions],
        );

        return [
            Attachment::fromData(fn() => $pdf->output(), 'summary.pdf'),
        ];
    }
}
