<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;

class IncrementInvoiceNumber
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
        $settings = json_decode($event->user->getUserSettings('sfNumberSettings')->value);
        $settings->sf_number = strval($settings->sf_number + 1);
        $jsonData = json_encode($settings);
        $event->user->meta()->updateOrCreate(
            ['name' => 'sfNumberSettings'],
            ['value' => $jsonData]
        );
    }
}
