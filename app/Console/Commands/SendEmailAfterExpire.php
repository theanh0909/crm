<?php

namespace App\Console\Commands;

use App\Jobs\BeforeExpire;
use App\Models\Registered;
use App\Models\Settings;
use App\Services\Production\MailService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailAfterExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autosendmail:afterexpire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $listDays = [
            0   => 'mail_auto_before_0day',
            1   => 'mail_auto_before_1day',
            3   => 'mail_auto_before_3day',
            7   => 'mail_auto_before_7day',
            10  => 'mail_auto_before_10day',
            15  => 'mail_auto_before_15day',
            30  => 'mail_auto_before_30day',
        ];

        foreach($listDays as $k => $v) {

            $checkDays = Carbon::now()->addDays($k)->format('Y-m-d');
            $customers = Registered::where('license_expire_date', $checkDays)->get();

            foreach ($customers as $customer) {
                dispatch(new BeforeExpire($v, $customer->email_customer, $customer->customer_name));
            }
        }
    }
}
