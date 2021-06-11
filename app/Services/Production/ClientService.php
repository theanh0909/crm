<?php

namespace App\Services\Production;

use App\Models\Feedback;
use App\Models\Registered;
use App\Models\License;
use App\Models\NRegistered;
use App\Models\Product;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Shared\OLE\PPS;

class ClientService extends BaseService
{
    public function __construct()
    {

    }

    protected function checkUpdate($params) {
        $clientKey = md5(trim($params['client_key']));

        $license = License::where('license_serial', $clientKey)->where('status', 1)->first();
        if ($license) {
            return "#BEGIN_RES#ACCESS_UPDATE#" . $params['client_key'] . "#END_RES#";
        }
        return "#BEGIN_RES#NO" . $params['client_key'] . "#END_RES#";
    }

    protected function checkInfo($params) {
        if ($params['customer_address'] == 'KHOACUNG') {
            $product = Product::where('product_type', $params['product'])->first();
            $data = "Bạn đang dùng khóa cứng" .
                    "|"."..............................."."|".
                    "..............................."."|".
                    "..............................."."|".
                    "..............................."."|".
                    "..............................."."|".
                    "..............................."."|".
                    "..............................."."|".$product->version."|".$product->key_version;
            return "#BEGIN_RES#" . $data .  "#END_RES#";
        } else {
            $splitcardkey = str_split($params['client_key'], 5);
            $splitcardkey = $splitcardkey[0] . "-" . $splitcardkey[1] . "-" . $splitcardkey[2] . "-" . $splitcardkey[3];

            $clientKey = md5(trim($splitcardkey));

            $customer = Registered::where('license_serial', $clientKey)
                        ->where('hardware_id', $params['client_hardware_id'])->first();
            if($customer && $customer->product && $customer->license) {

                $st1 = $params['client_key'];
                $str1 = substr($st1, 0, 5);
                $str2 = substr($st1, 5, 5);
                $str3 = substr($st1, 10, 5);
                $str4 = substr($st1, 15, 5);
                $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
                if ($customer->license->status == "1") {
                    $text = 'Bản thương mại';
                } else
                    $text = "Bản dùng thử";
                $Date = date('d/m/Y', strtotime($customer->license_activation_date));
                $Date_last = date('d/m/Y', strtotime($customer->license_expire_date));
                $data = $customer->customer_name . "|" . $customer->customer_address . "|"
                    . $customer->customer_email . "|" . $st . "|" . $Date . "|" . $Date_last . "|"
                    . $text . "|" . $customer->customer_phone . "|" . $customer->product->version . "|" . $customer->product->key_version;

                $customer->last_runing_date = Carbon::now()->format('Y-m-d');
                $customer->save();

                return "#BEGIN_RES#" . $data . "#END_RES#";
            }
            return "#BEGIN_RES##END_RES#";
        }
    }

    protected function checkResetup($params) {
        $customer = Registered::where('hardware_id', $params['client_hardware_id'])
                                ->where('product_type', $params['product'])
                                ->latest('license_expire_date')
                                ->get();
        $dem = 0;

        if (count($customer) > 0) {
            foreach ($customer as $customerItem) {
                $customerItem->last_runing_date = Carbon::now()->format('Y-m-d');
                $customerItem->save();
                
                if ($customerItem->license_expire_date >= Carbon::now()->format('Y-m-d')) {
                    $dem++;
                    $license_original = $customerItem->license_original;
                    break;
                }
            }
            if ($dem > 0) {
                return "#BEGIN_RES#KEY_VALID#" . $license_original.  "#END_RES#";
            } else {
                return '#BEGIN_RES#NOT_ACCESS#END_RES#';
            }
        } else {
            return '#BEGIN_RES#NOT_ACCESS#END_RES#';
        }
    }

    protected function checkResetup2($params) {
        // $customer = Registered::where('customer_email', $params['customer_email'])
        //                 ->where('hardware_id', $params['client_hardware_id'])
        //                 ->where('product_type', $params['product'])
        //                 ->first();
        $customer = Registered::where('customer_email', $params['customer_email'])
                        ->where('hardware_id', $params['client_hardware_id'])
                        ->where('product_type', $params['product'])
                        ->latest('license_expire_date')
                        ->get();
        $dem = 0;

        if (count($customer) > 0) {
            foreach ($customer as $customerItem) {
                $customerItem->last_runing_date = Carbon::now()->format('Y-m-d');
                $customerItem->save();
                
                if ($customerItem->license_expire_date >= Carbon::now()->format('Y-m-d')) {
                    $dem++;
                    $license_original = $customerItem->license_original;
                    break;
                }
            }
            if ($dem > 0) {
                return "#BEGIN_RES#KEY_VALID#" . $license_original.  "#END_RES#";
            } else {
                return '#BEGIN_RES#NOT_ACCESS#END_RES#';
            }
        } else {
            return '#BEGIN_RES#NOT_ACCESS#END_RES#';
        }
    }

    protected function checkExpire($params) {

        $splitcardkey = str_split($params['client_key'], 5);
        $splitcardkey = $splitcardkey[0] . "-" . $splitcardkey[1] . "-" . $splitcardkey[2] . "-" . $splitcardkey[3];

        $clientKey = md5(trim($splitcardkey));

        $customer = Registered::where('license_serial', $clientKey)->where('hardware_id', $params['client_hardware_id'])->first();
        if($customer) {
            $customer->last_runing_date = date('Y-m-d');
            $customer->save();
            if(strtotime($customer->license_expire_date) >= strtotime(Carbon::now()->format('Y-m-d'))) {
                return "#BEGIN_RES#KEY_VALID#" . $params['client_key'] . "#END_RES#";
            }
        }

        return "#BEGIN_RES#KEY_EXPIRED#" . $params['client_key'].'|'.Carbon::now()->format('Y-m-d') ."#END_RES#";
    }

    public function handleClientRequest($params)
    {
        try{
            $this->insertNRegisterd($params);

            if($params['customer_email'] == 'Check_resetup') {
                return $this->checkResetup($params);
            }

            $arrExcerpt = [
                'Check_update',
                'Check_info',
                'Check_resetup',
                'CheckExpire',
                'feedback'
            ];
            if(in_array($params['captcha'], $arrExcerpt)) {
                switch ($params['captcha']) {
                    case 'Check_update':
                        return $this->checkUpdate($params);
                        break;
                    case 'Check_info':
                        return $this->checkInfo($params);
                        break;
                    case 'Check_resetup':
                        return $this->checkResetup2($params);
                        break;
                    case 'CheckExpire':
                        return $this->checkExpire($params);
                        break;
                    case 'feedback':
                        return $this->feedback($params);
                        break;

                    default:
                        return "#BEGIN_RES##END_RES#";
                        break;
                }
            }


            $code = $this->handleRegsiterd($params);

            return $code;

        } catch (\Exception $e) {
            \Log::error($e);
            return false;
        }
    }

    public function handleClientRequestTest($params)
    {
        try{
            $this->insertNRegisterd($params);

            if($params['customer_email'] == 'Check_resetup') {
                return $this->checkResetup($params);
            }

            $arrExcerpt = [
                'Check_update',
                'Check_info',
                'Check_resetup',
                'CheckExpire',
                'feedback'
            ];
            if(in_array($params['captcha'], $arrExcerpt)) {
                switch ($params['captcha']) {
                    case 'Check_update':
                        return $this->checkUpdate($params);
                        break;
                    case 'Check_info':
                        return $this->checkInfo($params);
                        break;
                    case 'Check_resetup':
                        return $this->checkResetup2($params);
                        break;
                    case 'CheckExpire':
                        return $this->checkExpire($params);
                        break;
                    case 'feedback':
                        return $this->feedback($params);
                        break;

                    default:
                        return "#BEGIN_RES##END_RES#";
                        break;
                }
            }


            $code = $this->handleRegsiterdTest($params);

            return $code;

        } catch (\Exception $e) {
            \Log::error($e);
            return false;
        }
    }

    protected function feedback($params)
    {
        if(empty($params['client_title']) || empty($params['client_content']))
            return "#BEGIN_RES#KEY_NOTVALID#" . $params['client_key'] . "#END_RES#";

        $splitcardkey = str_split($params['client_key'], 5);
        $splitcardkey = $splitcardkey[0] . "-" . $splitcardkey[1] . "-" . $splitcardkey[2] . "-" . $splitcardkey[3];

        $clientKey = md5(trim($splitcardkey));

        $customer = Registered::where('license_serial', $clientKey)->where('hardware_id', $params['client_hardware_id'])->first();
        if($customer) {
            Feedback::create([
                'customer_id'   => $customer->id,
                'title'         => $params['client_title'],
                'content'       => $params['client_content'],
            ]);
        }
        return "#BEGIN_RES#KEY_VALID#" . $params['client_key'] . "#END_RES#";
    }

    protected function updateRgistered($checkKeyAgaint, $params)
    {
        $checkKeyAgaint->customer_name      = $params['customer_name'];
        $checkKeyAgaint->customer_phone     = $params['customer_phone'];
        $checkKeyAgaint->customer_email     = $params['customer_email'];
        $checkKeyAgaint->customer_address   = $params['customer_address'];
        $checkKeyAgaint->last_runing_date   = Carbon::now()->format('Y-m-d');
        $checkKeyAgaint->customer_cty       = $params['province'];
        $checkKeyAgaint->hardware_id        = $params['client_hardware_id'];
        $checkKeyAgaint->save();
    }

    protected function addClientInfo($params)
    {
        $dataInsert = [
            'license_serial'            => md5(trim($params['client_key'])),
            'license_original'          => $params['client_key'],
            'hardware_id'               => $params['client_hardware_id'],
            'customer_name'             => $params['customer_name'],
            'customer_phone'            => $params['customer_phone'],
            'customer_email'            => $params['customer_email'],
            'customer_address'          => $params['customer_address'],
            'license_activation_date'   => Carbon::now()->format('Y-m-d'),
            'last_runing_date'          => Carbon::now()->format('Y-m-d'),
            'license_expire_date'       => $params['license_expire_date'],
            'product_type'              => $params['product'],
            'customer_cty'              => $params['province'],
            'number_has_change_key'     => $params['number_has_change_key'],
            'number_can_change_key'     => $params['number_can_change_key'],
            'user_support_id'           => $params['user_support_id'],
        ];

        Registered::create($dataInsert);
    }

    public function handleRegsiterd($params)
    {

        $splitcardkey = str_split($params['client_key'], 5);
        $splitcardkey = $splitcardkey[0] . "-" . $splitcardkey[1] . "-" . $splitcardkey[2] . "-" . $splitcardkey[3];
        $params['client_key'] = $splitcardkey;

        $dataCreateInfo = $params;

        $md5_key = md5(trim($splitcardkey));
        $license = License::where('license_serial', $md5_key)->where('product_type', $params['product'])->first();
        if(!$license) {
            return "#BEGIN_RES#KEY_NOTVALID#" . $splitcardkey . "#END_RES#";
        }
        $customer = $license->customer;

        if($customer) {
            if($customer->customer_email == $params['customer_email']) {
                $checkKeyExpire = (strtotime(Carbon::parse($customer->license_activation_date)->addDays($license->type_expire_date)->format('Y-m-d')) > time()) ? true : false;
                if(!$checkKeyExpire) {
                    return "#BEGIN_RES#KEY_EXPIRED#" . $splitcardkey.'|'.date('d/m/Y') ."#END_RES#";
                }

                if($customer->hardware_id == $params['client_hardware_id']) {
                    $customer->last_runing_date = Carbon::now()->format('Y-m-d');
                    $customer->save();
                    $this->sendMailAfterRegister($params['customer_email'], $license->status);
                    return "#BEGIN_RES#KEY_VALID#" . $splitcardkey . "#END_RES#";
                } else {
                    if($customer->number_has_change_key >= $customer->number_can_change_key) {
                        return "#BEGIN_RES#KEY_EXPIRED#" . $splitcardkey.'|'.$customer->number_has_change_key ."#END_RES#";
                    }
                }

                $customer->last_runing_date = Carbon::now()->format('Y-m-d');
                $customer->hardware_id = $params['client_hardware_id'];
                $customer->number_has_change_key = $customer->number_has_change_key + 1;
                $customer->save();
                $this->sendMailAfterRegister($params['customer_email'], $license->status);
                return "#BEGIN_RES#KEY_VALID#" . $splitcardkey . "#END_RES#";
            }
            return "#BEGIN_RES#KEY_NOTVALID#" . $splitcardkey . "#END_RES#";
        } else {

            $product = $license->product;

            $license->hardware_id       = $params['client_hardware_id'];
            $license->email_customer    = $params['customer_email'];
            $license->status_register   = 1;
            $license->save();

            $dataCreateInfo['license_expire_date'] = Carbon::now()->addDays($license->type_expire_date)->format('Y-m-d H:i:s');
            $dataCreateInfo['number_has_change_key'] = 1;
            $dataCreateInfo['number_can_change_key'] = $product->number_of_change;
            $dataCreateInfo['user_support_id']       = $license->id_user;

            $this->addClientInfo($dataCreateInfo);
            NRegistered::where('email', $params['customer_email'])->where('product_type', $params['product'])->delete();

            $this->sendMailAfterRegister($params['customer_email'], $license->status);
            return "#BEGIN_RES#KEY_VALID#" . $splitcardkey . "#END_RES#";
        }

    }

    public function handleRegsiterdTest($params)
    {
        $splitcardkey = str_split($params['client_key'], 5);
        $splitcardkey = $splitcardkey[0] . "-" . $splitcardkey[1] . "-" . $splitcardkey[2] . "-" . $splitcardkey[3];
        $params['client_key'] = $splitcardkey;

        $dataCreateInfo = $params;

        $md5_key = md5(trim($splitcardkey));
        $license = License::where('license_serial', $md5_key)
                           ->where('product_type', $params['product'])
                           ->first();

        if (!$license) {
            return "#BEGIN_RES#KEY_NOTVALID#" . $splitcardkey . "#END_RES#";
        }
        $customer = $license->customer;
        
        if ($license->status_register == 0) {
            // Key chưa được đăng ký
                $product = $license->product;

                $license->hardware_id       = $params['client_hardware_id'];
                $license->status_register   = 1;
                $license->save();

                $dataCreateInfo['license_expire_date'] = Carbon::now()->addDays($license->type_expire_date)->format('Y-m-d H:i:s');
                $dataCreateInfo['number_has_change_key'] = 1;
                $dataCreateInfo['number_can_change_key'] = $product->number_of_change;
                $dataCreateInfo['user_support_id']       = $license->id_user;

                $this->addClientInfo($dataCreateInfo);
                // NRegistered::where('email', $params['customer_email'])->where('product_type', $params['product'])->delete();

                return "#BEGIN_RES#KEY_VALID#" . $splitcardkey . "#END_RES#";
        } else {
            if ($customer) {
                // if ($customer->customer_email == $params['customer_email']) {
                    $checkKeyExpire = (strtotime(Carbon::parse($customer->license_activation_date)->addDays($license->type_expire_date)->format('Y-m-d')) > time()) ? true : false;
                /** 
                 * Kiểm tra xem key đó hết hạn chưa
                */
                    if (!$checkKeyExpire) {
                        return "#BEGIN_RES#KEY_EXPIRED#" . $splitcardkey.'|'.date('d/m/Y') ."#END_RES#";
                    }
                /**
                 * Kiểm tra xem id máy gửi lên có trùng với máy cũ không, nếu trùng thì chạy bth, ngược lại thì tăng số lần lên đến mức cho phép
                 */
                    if ($customer->hardware_id == $params['client_hardware_id']) {
                        $customer->last_runing_date = Carbon::now()->format('Y-m-d');
                        $customer->save();
                        // $this->sendMailAfterRegister($params['customer_email'], $license->status);

                        return "#BEGIN_RES#KEY_VALID#" . $splitcardkey . "#END_RES#";
                    } else {
                        if ($customer->number_has_change_key >= $customer->number_can_change_key) {
                            return "#BEGIN_RES#KEY_EXPIRED#" . $splitcardkey.'|'.$customer->number_has_change_key ."#END_RES#";
                        } else {
                            $customer->last_runing_date = Carbon::now()->format('Y-m-d');
                            $customer->hardware_id = $params['client_hardware_id'];
                            $customer->number_has_change_key = $customer->number_has_change_key + 1;
                            $customer->save();

                            return "#BEGIN_RES#KEY_VALID#" . $splitcardkey . "#END_RES#";
                        }
                    }
                    // $customer->last_runing_date = Carbon::now()->format('Y-m-d');
                    // $customer->hardware_id = $params['client_hardware_id'];
                    // $customer->number_has_change_key = $customer->number_has_change_key + 1;
                    // $customer->save();
                    // $this->sendMailAfterRegister($params['customer_email'], $license->status);
                    // return "#BEGIN_RES#KEY_VALID#" . $splitcardkey . "#END_RES#";
                // }
                // return "#BEGIN_RES#KEY_NOTVALID#" . $splitcardkey . "#END_RES#";
            } else {
                 $product = $license->product;

                 $license->hardware_id       = $params['client_hardware_id'];
                 $license->email_customer    = $params['customer_email'];
                 $license->status_register   = 1;
                 $license->save();

                 $dataCreateInfo['license_expire_date'] = Carbon::now()->addDays($license->type_expire_date)->format('Y-m-d H:i:s');
                 $dataCreateInfo['number_has_change_key'] = 1;
                 $dataCreateInfo['number_can_change_key'] = $product->number_of_change;
                 $dataCreateInfo['user_support_id']       = $license->id_user;

                 $this->addClientInfo($dataCreateInfo);
                 NRegistered::where('email', $params['customer_email'])->where('product_type', $params['product'])->delete();

                 // $this->sendMailAfterRegister($params['customer_email'], $license->status);
                 return "#BEGIN_RES#KEY_VALID#" . $splitcardkey . "#END_RES#";
             }
        }
    }

    public function insertNRegisterd($params)
    {
        $inputs = [
            'product_type'      => $params['product'],
            'email'             => $params['customer_email'],
            'name'              => $params['customer_name'],
            'tel'               => $params['customer_phone'],
            'address'           => $params['customer_address'],
            'date1'             => Carbon::now()->format('Y-m-d'),
            'key1'              => $params['client_key'],
            'customer_cty'      => (isset($params['province'])) ? $params['province'] : 'NA',
            'hardware_id'       => $params['client_hardware_id'],
        ];

        NRegistered::create($inputs);
    }

    protected function sendMailAfterRegister($emailCustomer, $status)
    {
        try {
            $key = ($status == 1) ? 'mail_after_register_commercial' : 'mail_after_register_trial';
            $email = Settings::where('key', $key)->first();
            if($email) {
                Mail::send([], [], function($message) use ($email, $emailCustomer) {
                    $message->to($emailCustomer)
                        ->subject($email->value->subject)
                        ->setBody($email->value->content, 'text/html');
                });
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


}