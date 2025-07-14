<?php

namespace App\Mail;

use App\Models\TechnicalReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class TechnicalReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public TechnicalReport $report;

    /**
     * Create a new message instance.
     */
    public function __construct(TechnicalReport $report)
    {
        $this->report = $report->load('customer');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Laudo Técnico #' . $this->report->report_number . ' - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.technical-report',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $attachments = [];
        
        // Generate PDF and attach
        $pdf = Pdf::loadView('technical-reports.pdf', ['report' => $this->report]);
        $filename = 'laudo-tecnico-' . $this->report->report_number . '.pdf';
        
        $attachments[] = Attachment::fromData(
            fn () => $pdf->output(),
            $filename
        )->withMime('application/pdf');

        return $attachments;
    }
}
