<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $workOrder;
    protected $pdf;

    public function __construct($workOrder, PDF $pdf)
    {
        $this->workOrder = $workOrder;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Invoice Work Order ' . $this->workOrder->nomor_wo)
                    ->view('emails.invoice')   // buat view email sederhana
                    ->attachData($this->pdf->output(), 'invoice_'.$this->workOrder->nomor_wo.'.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}