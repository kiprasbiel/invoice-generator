<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use SerializesModels;

    private array $data;
    private Invoice $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data, Invoice $invoice)
    {
        $this->data = $data;
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): InvoiceMail {
        $pdfArr = $this->invoice->getInvoice();
        return $this->view('mail.invoice', $this->data)
            ->attachData($pdfArr['pdf-data'], $pdfArr['pdf-name'], [
                'mime' => 'application/pdf',
            ]);
    }
}
