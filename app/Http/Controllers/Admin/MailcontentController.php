<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\Product;
use App\Models\Settings;
use Illuminate\Http\Request;

class MailcontentController extends Controller
{
    protected $arrayTypes = [
        'mail_after_register_commercial'    => 'Email bản thương mại sau khi kích hoạt',
        'mail_after_register_trial'         => 'Email bản dùng thử sau khi kích hoạt',
        'mail_renewed_key_success'          => 'Email gia hạn thành công',
        'mail_remake_key_success'           => 'Email gia hạn thành công',
    ];

    public function list()
    {
        $arrayTypes = Settings::getArrayTypes();
        return view('admin.mailcontent.list', compact( 'arrayTypes'));
    }

    public function index($type)
    {
        $content    = Settings::where('key', $type)->first();
        $arrayTypes = Settings::getArrayTypes();
        return view('admin.mailcontent.index', compact('type', 'arrayTypes', 'content'));
    }


    public function update(Request $request, $type)
    {
        $inputs = $request->only(['subject', 'content']);

        $content = Settings::where('key', $type)->first();
        if($content) {
            $content->value = $inputs;
            $content->save();
        } else {
            $newSetting = new Settings();
            $newSetting->key    = $type;
            $newSetting->value  = $inputs;
            $newSetting->save();
        }

        return redirect()->route('admin.mailcontent.index', ['type' => $type]);
    }
}
