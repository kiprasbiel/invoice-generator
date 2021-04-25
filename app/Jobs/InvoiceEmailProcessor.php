<?php

namespace App\Jobs;

use App\Mail\InvoiceMail;
use App\Models\InvoiceEmail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class InvoiceEmailProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // TODO: Pridet galimybe nustatymuose susikurt Email info
        InvoiceEmail::where('due_date', Carbon::now()->format('Y-m-d'))
            ->get()
            ->map(function($time) {
                $invoiceModel = $time->invoice;
                $data = [
                    'headline' => 'Defaultinis headlinas!',
                    'messageBody' => 'Defaultinis bodis!',
                    'username' => $invoiceModel->user->name,
                ];

                Mail::to('veliau-pakeist@svarbu.labai')->send(new InvoiceMail($data, $invoiceModel));
            });
    }
}
