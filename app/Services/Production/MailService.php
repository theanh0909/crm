<?php
namespace App\Services\Production;

use App\Models\License;
use App\Models\Settings;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public static function sendMailAfterRegister($emailCustomer, $key)
    {
        try {
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

    public static function sendEmailProduct($email, $customerEmail, $customerName, $key, $status = 1)
    {
        try {
            if($customerName == '') {
                $customerName = 'Quý khách';
            }
            Mail::send([], [], function($message) use ($email, $customerEmail, $customerName, $key, $status) {
                if($status == License::STATUS_COMMERCIAL) {
                    $subject = str_replace( "[name]", $customerName, $email->subject );
                    $body    = str_replace( "[name]", $customerName, $email->content );
                    $body    = str_replace( 'PASTE_KEY', $key, $body );    
                    $message->to($customerEmail)
                        ->subject($subject)
                        ->setBody($body, 'text/html');
                } else {
                    $subject = str_replace( "[name]", $customerName, $email->subject_trial );
                    $body    = str_replace( "[name]", $customerName, $email->content_trial );
                    $body    = str_replace( 'PASTE_KEY', $key, $body );
                    $message->to($customerEmail)
                        ->subject($subject)
                        ->setBody($body, 'text/html');
                }
            });
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        
    }
}
