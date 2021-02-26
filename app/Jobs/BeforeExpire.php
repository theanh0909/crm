<?php

namespace App\Jobs;

use App\Models\Registered;
use App\Models\Settings;
use App\Services\Production\MailService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class BeforeExpire implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($template, $customerEmail, $customerName)
    {
        $this->template         = $template;
        $this->customerEmail    = $customerEmail;
        $this->customerName     = $customerName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = Settings::where('key', $this->template)->first();
        if($email) {
            $customerName = $this->customerName;
            $customerEmail = $this->customerEmail;

            Mail::send([], [], function($message) use ($email, $customerName, $customerEmail) {
                $subject = str_replace( "[name]", $customerName, $email->value->subject );
                $body    = str_replace( "[name]", $customerName, $email->value->content );

                $message->to($customerEmail)
                    ->subject($subject)
                    ->setBody($body, 'text/html');
            });
        }
    }
}
