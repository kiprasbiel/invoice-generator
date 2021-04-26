<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;
use Carbon\Carbon;

class RegisterNewInvoiceEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceCreated  $event
     * @return void
     */
    public function handle(InvoiceCreated $event)
    {
        $invoice = $event->invoice;
        if($invoice->pay_by && $invoice->pay_by->greaterThanOrEqualTo(Carbon::now()->format('Y-m-d')) && $invoice->email) {
            $event->invoice->email()->create([
                'due_date' => $invoice->pay_by->format('Y-m-d'),
            ]);
        }
    }
}
