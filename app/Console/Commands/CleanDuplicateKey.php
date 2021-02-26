<?php

namespace App\Console\Commands;

use App\Models\License;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanDuplicateKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
        protected $signature = 'clean:duplicatekey';

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
        $duplicateKey = DB::select("SELECT license_key FROM license GROUP BY license_key HAVING COUNT(*) > 1");
        $i = 0;
        foreach($duplicateKey as $key) {
            $license_key = $key->license_key;
            $duplicates = License::where('license_key', $license_key)->get();
            foreach($duplicates as $duplicate) {
                if(
                    $duplicate->exported_status == 0 &&
                    $duplicate->exported == 0 &&
                    $duplicate->status_register == 0 &&
                    $duplicate->status_email == 0
                ) {
                    $duplicate->delete();
                    echo "DELETED -" . $duplicate->license_key . PHP_EOL;
                    $i++;
                }
            }
        }

        echo $i;

//        dd($duplicateKey);
    }
}
