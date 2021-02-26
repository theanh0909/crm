<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\GetKeyRequest;
use App\Http\Requests\Api\Client\HandleClientRequest;
use App\Models\ApiAuth;
use App\Models\License;
use App\Models\Product;
use App\Models\Registered;
use App\Models\Settings;
use App\Services\Production\ClientService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function update(Request $request)
    {
        try {
            $params = $request->all();
            License::where('license_key', trim($params['client_key']))
                    ->update([
                        'email_customer' => $params['customer_email'],
                        'customer_name' => $params['customer_name'],
                        'customer_phone' => $params['customer_phone'],
                    ]);
            Registered::where('license_original', trim($params['client_key']))
                    ->update([
                            'customer_name' => $params['customer_name'],
                            'customer_phone' => $params['customer_phone'],
                            'customer_email' => $params['customer_email'],
                            'customer_address' => $params['customer_address'],
                    ]);
            
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }

    public function handleClient(HandleClientRequest $request)
    {
        $inputs = $request->only([
            'client_key',
            'client_hardware_id',
            'customer_name',
            'customer_phone',
            'customer_email',
            'customer_address',
            'product',
            'captcha',
            'province',
            'client_title',
            'client_content'
        ]);

        $handle = $this->clientService->handleClientRequest($inputs);
        return view('client_register', compact('handle'));
    }

    public function test(HandleClientRequest $request)
    {
        $inputs = $request->only([
            'client_key',
            'client_hardware_id',
            'customer_name',
            'customer_phone',
            'customer_email',
            'customer_address',
            'product',
            'captcha',
            'province',
            'client_title',
            'client_content'
        ]);

        $inputs['customer_name'] = 'NA';
        $inputs['customer_phone'] = 'NA';
        $inputs['customer_email'] = 'NA';
        $inputs['captcha'] = 'NA';
        $inputs['customer_address'] = 'NA';
        $inputs['province'] = 'NA';

        $handle = $this->clientService->handleClientRequestTest($inputs);
        return view('client_register', compact('handle'));
    }

    public function getKey(GetKeyRequest $request)
    {
        $header = array (
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'
        );

        $key    = $request->header('secret');
        $domain = $request->header('domain');

        if(!$key || !$domain) {
            return response()->json([
                'success'   => false,
                'code'      => Settings::API_ERROR_KEY,
                'message'   => 'Thiếu khóa bảo mật',
            ], 200, $header, JSON_UNESCAPED_UNICODE);
        }

        $auth = ApiAuth::where('domain', $domain)->where('key', $key)->first();
        if(!$auth) {
            return response()->json([
                'success'   => false,
                'code'      => Settings::API_ERROR_KEY,
                'message'   => 'Khóa bảo mật không đúng',
            ], 200, $header, JSON_UNESCAPED_UNICODE);
        }

        $inputs = $request->only([
            'quantity',
            'product',
            'key_type',
            'expire_date',
        ]);

        $product = Product::where('product_type', $inputs['product'])->first();
        if(!$product) {
            return response()->json([
                'success'   => false,
                'code'      => Settings::API_ERROR_PRODUCT,
                'message'   => 'Không tìm thấy sản phẩm',
            ], 200, $header, JSON_UNESCAPED_UNICODE);
        }

        $count = License::where('product_type', $inputs['product'])
                        ->where('status', $inputs['key_type'])
                        ->where('exported_status', 0)
                        ->where('status_email', 0)
                        ->where('exported', 0)
                        ->where('status_register',License::KEY_NOT_ACTIVE)
                        ->where('type_expire_date', $inputs['expire_date'])
                        ->count();

        if($count < $inputs['quantity']) {
            return response()->json([
                'success'   => false,
                'code'      => Settings::API_ERROR_OUTOF,
                'message'   => 'Số lương Key không đủ',
            ], 200, $header, JSON_UNESCAPED_UNICODE);
        }

        $datas = License::where('product_type', $inputs['product'])
                        ->where('status', $inputs['key_type'])
                        ->where('exported_status', 0)
                        ->where('status_email', 0)
                        ->where('exported', 0)
                        ->where('status_register',License::KEY_NOT_ACTIVE)
                        ->where('type_expire_date', $inputs['expire_date'])
                        ->orderBy('id', 'ASC')
                        ->limit($inputs['quantity'])
                        ->get();

        $result = [];
        foreach($datas as $data) {
            $result[] = [
                'license_serial'        => $data->license_serial,
                'license_key'           => $data->license_key,
                'type_expire_date'      => $data->type_expire_date,
                'license_created_date'  => $data->license_created_date,
                'status'                => $data->status,
            ];

            $data->exported_status = License::EP_EXPORT_API;
            $data->domain = $domain;
            $data->save();
        }

        return response()->json([
            'success'   => true,
            'code'      => Settings::API_SUCCESS,
            'data'      => $result
        ], 200, $header, JSON_UNESCAPED_UNICODE);
    }
}
