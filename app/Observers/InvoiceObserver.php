<?php

namespace App\Observers;

use App\Events\InvoiceCreated;
use App\Models\Invoice;

class InvoiceObserver
{
    /**
     * Handle the Invoice "created" event.
     *
     * @param Invoice $invoice
     * @return void
     */
    public function created(Invoice $invoice) {
        InvoiceCreated::dispatch($invoice);
    }
}
