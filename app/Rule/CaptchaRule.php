<?php

namespace App\Rule;

use App\Models\Captcha;
use Illuminate\Contracts\Validation\Rule;

class CaptchaRule implements Rule
{
    public function passes($attribute, $value)
    {
        $arrExcerpt = [
            'Check_update',
            'Check_info',
            'Check_resetup',
            'CheckExpire',
            'feedback',
            'NA',
        ];
        if(in_array($value, $arrExcerpt)) {
            return true;
        }

        $captcha = Captcha::where('captcha_text', $value)->where('ip_address', request()->ip())->count();
        if($captcha > 0) {
            Captcha::where('captcha_text', $value)->where('ip_address', request()->ip())->delete();

            return true;
        }
        return false;
    }

    public function message()
    {
        return 'Captcha invalid';
    }
}
