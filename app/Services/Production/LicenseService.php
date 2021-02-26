<?php
namespace App\Services\Production;

use App\Models\License;
use App\Repositories\LicenseRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LicenseService extends BaseService
{
    public $licenseRepository;

    public function __construct(LicenseRepositoryInterface $licenseRepository)
    {
        $this->licenseRepository = $licenseRepository;
    }

    public function createNewLicenseKey($params)
    {
        $results = [];
        // $passphrase = "bachkhoa12";
        // $private_key = sprintf(\Illuminate\Support\Facades\File::get(app_path() . '/Modules/PKI/private/server.key'));
        // $maxLicense = License::orderBy('id', 'DESC')->first();
        // $max_id = ($maxLicense) ? $maxLicense->id : 0;
        // $key_created_date   = $params['license_created_date'];
        // $key_expire_date    = $params['type_expire_date'];
        // $no_computers       = $params['license_no_computers'];
        // $no_instances       = $params['license_no_instance'];

        for ($i = 0; $i < $params['no_keys']; $i++ ) {
            $licenseKey = $this->generateLicenseKey($params, $i);
            // $key = sprintf("hiephv%s%s%d%d%d", $key_created_date, $key_expire_date, $no_computers, $no_instances, $max_id + $i + 1);
            // $key = md5($key);
            // $res = openssl_get_privatekey($private_key, $passphrase);
            // if (!$res) {
            //     openssl_error_string();
            //     return;
            // }
            //sign data with private key
            // $crypted_key = "";
            // openssl_private_encrypt($key, $crypted_key, $res);

        /*change to HEX format which can be read by user*/
            //$hexkey = strToHex($crypted_key); //day ma dai 256 ky tu hexa
        /*extract the first 20 characters which used to write down to card*/
            // $cardkey = substr($hexkey, 0, 20);
            // $cardkey = strtoupper($cardkey);
            // $splitcardkey = str_split($cardkey, 5);
            // $splitcardkey = $splitcardkey[0] . "-" . $splitcardkey[1] . "-" . $splitcardkey[2] . "-" . $splitcardkey[3];
            // $md5cardkey = md5($cardkey);

            $params['license_serial'] = md5($licenseKey); //$md5cardkey; 
            $params['license_key']    = $licenseKey; //$splitcardkey;

            //$check = DB::table('license')->where('license_serial', $md5cardkey)->count();

            //if ($check == 0) {
                $afterCreate = $this->licenseRepository->create($params);
                $params['id']      = $afterCreate->id;
                $params['product'] = $afterCreate->product;

                $results[] = $params;
            //}
            
        }

        return $results;
    }

    public function generateLicenseKey($params, $i)
    {
        $passphrase = "bachkhoa12";
        $private_key = \Illuminate\Support\Facades\File::get(app_path() . '/Modules/PKI/private/server.key');

        $key_created_date   = $params['license_created_date'];
        $key_expire_date    = $params['type_expire_date'];
        $no_computers       = $params['license_no_computers'];
        $no_instances       = $params['license_no_instance'];

        $maxLicense = License::orderBy('id', 'DESC')->first();
        $max_id = ($maxLicense) ? $maxLicense->id : 0;

        $key = sprintf("hiephv%s%s%d%d%d",
            $key_created_date,
            $key_expire_date,
            $no_computers,
            $no_instances,
            $max_id + $i + 1
        );
        $key = md5($key);
        $res = openssl_get_privatekey($private_key, $passphrase);
        if (!$res) {
            openssl_error_string();
            return;
        }
        //sign data with private key
        $crypted_key = "";
        openssl_private_encrypt($key, $crypted_key, $res);

        //change to HEX format which can be read by user
        $hexkey = strToHex($crypted_key); //day ma dai 256 ky tu hexa
        //extract the first 20 characters which used to write down to card
        $cardkey = substr($hexkey, 0, 20);
        $cardkey = strtoupper($cardkey);

        $splitcardkey = str_split($cardkey, 5);
        $splitcardkey = $splitcardkey[0] . "-" . $splitcardkey[1] . "-" . $splitcardkey[2] . "-" . $splitcardkey[3];

        $check = DB::table('license')->where('license_key', $splitcardkey)->count();
        if($check > 0) {
            return $this->generateLicenseKey($params, $i);
        }

        return $splitcardkey;
    }
}
