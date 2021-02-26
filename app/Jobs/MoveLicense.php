<?php

namespace App\Jobs;

use App\Models\License;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class MoveLicense implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $limit = 100;

    public $offset = 0;

    public function __construct($limit, $offset)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $licenses = DB::connection('olddb')->table('license')
            ->orderBy('id', 'DESC')
            ->limit($this->limit)->offset($this->offset)->get();

        foreach ($licenses as $license) {
            $dataInsert = [
                'license_serial' => $license->license_serial,
                'license_key'    => $license->license_key,
                'license_is_registered' => $license->license_is_registered,
                'license_created_date'  => ($license->license_created_date != '0000-00-00') ? $license->license_created_date : Carbon::now()->format('Y-m-d'),
                'type_expire_date'      => $license->type_expire_date,
                'hardware_id'           => $license->hardware_id,
                'license_no_instance'   => $license->license_no_instance,
                'license_no_computers'  => $license->license_no_computers,
                'status'                => ($license->status) ? $license->status : 0,
                'status_register'       => $license->stt_reg,
                'email_customer'        => $license->email_cus,
                'sell_date'             => ($license->Sell != '0000-00-00') ? $license->Sell : Carbon::now()->format('Y-m-d'),
                'status_sell'           => $license->Stt_sell,
                'status_email'          => $license->stt_email,
                'used'                  => $license->is_used,
            ];

            if($license->product_type != '') {
                $pT = DB::table('product_type')->where('name', $license->product_type)->first();
                if($pT) {
                    $dataInsert['product_type_id'] = $pT->id;
                } else {
                    $dataInsert['product_type_id'] = 0;
                }
            } else {
                $dataInsert['product_type_id'] = 0;
            }

//            dd($dataInsert);

            License::create($dataInsert);
//            DB::table('license')->insert($dataInsert);
        }

        dispatch(new MoveLicense($this->limit, $this->offset + $this->limit));
    }
}
