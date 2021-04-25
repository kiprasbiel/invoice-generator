<?php

namespace App\Providers;

use App\Events\InvoiceCreated;
use App\Listeners\CreateUserDefaultSettings;
use App\Listeners\IncrementInvoiceNumber;
use App\Listeners\RegisterNewInvoiceEmail;
use App\Models\Invoice;
use App\Observers\InvoiceObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            CreateUserDefaultSettings::class,
        ],
        InvoiceCreated::class => [
            IncrementInvoiceNumber::class,
            RegisterNewInvoiceEmail::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Invoice::observe(InvoiceObserver::class);
    }
}
