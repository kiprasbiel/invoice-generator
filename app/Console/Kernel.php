<?php

namespace App\Console;

use App\Mail\InvoiceMail;
use App\Models\InvoiceEmail;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
            InvoiceEmail::where('due_date', Carbon::now()->format('Y-m-d'))->get()
                ->map(function($time) {
                    $invoiceModel = $time->invoice;
                    $mailData = $invoiceModel->user->getMailSettings();
                    if (!$mailData->autoSend || $invoiceModel->is_payed) {
                        $time->delete();
                        return;
                    }
                    $data = [
                        'headline' => $mailData->headline,
                        'messageBody' => $mailData->messageBody,
                        'username' => $invoiceModel->user->getDecodedUserSettings('userActivitySettings', 'full_name'),
                    ];
                    Mail::to($invoiceModel->email)->send(new InvoiceMail($data, $invoiceModel));
                    $time->delete();
                });
        })->dailyAt('10:00');

        // TODO: padaryt automatini senu irasu trinima
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
