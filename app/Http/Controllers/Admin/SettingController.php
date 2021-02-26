<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiAuth;
use App\Models\ProductType;
use App\Http\Requests\Admin\ProductType\StoreRequest;
use App\Http\Requests\Admin\ProductType\UpdateRequest;
use App\Models\Settings;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\Production\CustomerRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class SettingController extends Controller
{
    protected $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }


    public function email()
    {
        $fields = [
            'driver'        => 'Driver',
            'host'          => 'Host',
            'port'          => 'Port',
            'from_email'    => 'From Email',
            'from_name'     => 'From Name',
            'encryption'    => 'Encryption',
            'account'       => 'Username',
            'password'      => 'Password',
        ];

        $emailSetting = Settings::where('key', 'email_setting')->first();
        $setting = ($emailSetting) ? $emailSetting->value : [];
        return view('admin.settings.email', compact('setting', 'fields'));
    }

    public function updateEmail(Request $request)
    {
        $inputs = $request->only([
            'driver',
            'host',
            'port',
            'account',
            'password',
            'from_email',
            'from_name',
            'encryption',
        ]);
        $emailSetting = Settings::where('key', 'email_setting')->first();
        if($emailSetting) {
            $emailSetting->value = $inputs;
            $emailSetting->save();
        } else {
            $newSetting = new Settings();
            $newSetting->key    = 'email_setting';
            $newSetting->value  = $inputs;
            $newSetting->save();
        }

        return redirect()->route('admin.settings.email');
    }

    public function system()
    {
        $fields = [
            'company_name'  => 'Tên công ty',
            'title'         => 'Tiêu đề',
            'keywords'      => 'Từ khóa',
            'location'      => 'Vị trí, Tọa độ',
            'address'       => 'Địa chỉ',
            'region'        => 'Khu vực',
            'license'       => 'Bản quyền',
            'author'        => 'Tác giả',
            'description'   => 'Mô tả',
        ];

        $settingQuery = Settings::where('key', 'system_setting')->first();
        $setting = ($settingQuery) ? $settingQuery->value : [];

        return view('admin.settings.system', compact('setting', 'fields'));
    }

    public function updateSystem(Request $request)
    {
        $inputs = $request->all();
        unset($inputs["_token"]);

        $emailSetting = Settings::where('key', 'system_setting')->first();
        if($emailSetting) {
            $emailSetting->value = $inputs;
            $emailSetting->save();
        } else {
            $newSetting = new Settings();
            $newSetting->key    = 'system_setting';
            $newSetting->value  = $inputs;
            $newSetting->save();
        }

        return redirect()->route('admin.settings.system');
    }

    public function api()
    {
        $fields = [
            'api_key'         => 'Mã khóa',
        ];

        $models = ApiAuth::all();

        return view('admin.settings.api', compact('models', 'fields'));
    }

    public function createApi(Request $request)
    {
        $inputs = $request->all();

        ApiAuth::create($inputs);

        return redirect()->route('admin.settings.api');
    }

    public function deleteApi($id)
    {
        $key = ApiAuth::find($id);
        $key->delete();

        return redirect()->route('admin.settings.api');
    }

    public function editApi($id)
    {
        $key = ApiAuth::find($id);

        return view('admin.settings.edit_api', compact('key'));
    }

    public function updateApi(Request $request, $id)
    {
        $inputs = $request->all();
        $key = ApiAuth::find($id);
        $key->domain = $inputs['domain'];
        $key->key       = $inputs['key'];

        $key->save();

        return redirect()->route('admin.settings.api');
    }
}
