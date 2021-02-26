<?php

namespace App\Console\Commands;

use App\Models\Email;
use Illuminate\Console\Command;

class SendEmailKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendemail:key';

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

        dispatch(new \App\Jobs\SendEmailKey(
            'DutoanGXD2020',
            'lyhoi.2204@gmail.com',
            'Ly Hoi Job',
            'dasfafdfdffdfd',
            '1',
            'lyhoi.2204@gmail.com'
        ));
    }
}
