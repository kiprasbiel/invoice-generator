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
        $pay_by = $event->invoice->pay_by;
        if($pay_by && $pay_by->greaterThan(Carbon::now())) {
            $event->invoice->email()->create([
                'due_date' => $pay_by->format('Y-m-d'),
            ]);
        }
    }
}
