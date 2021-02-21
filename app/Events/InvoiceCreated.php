<?php

namespace App\Events;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class InvoiceCreated
{
    use Dispatchable;

    public $invoice;
    public $user;

    /**
     * Create a new event instance.
     *
     * @param Invoice $invoice
     * @param User $user
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->user = auth()->user();
    }
}
