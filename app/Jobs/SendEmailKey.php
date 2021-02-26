<?php

namespace App\Jobs;

use App\Models\Email;
use App\Services\Production\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailKey implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $productType;
    protected $customerEmail;
    protected $customerName;
    protected $licenseKey;
    protected $licenseStatus;
    protected $authEmail;

    public function __construct($productType, $customerEmail, $customerName, $licenseKey, $licenseStatus, $authEmail)
    {

        $this->productType      = $productType;
        $this->customerEmail    = $customerEmail;
        $this->customerName     = $customerName;
        $this->licenseKey       = $licenseKey;
        $this->licenseStatus    = $licenseStatus;
        $this->authEmail        = $authEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$this->productType
        $email = Email::where('product_type', $this->productType)->first();

        MailService::sendEmailProduct($email, $this->customerEmail, $this->customerName, $this->licenseKey, $this->licenseStatus);
        MailService::sendEmailProduct($email, $this->authEmail, $this->customerName, $this->licenseKey, $this->licenseStatus);
    }
}
