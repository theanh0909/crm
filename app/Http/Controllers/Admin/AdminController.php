<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Registered;
use App\Permission;
use App\Repositories\CustomerRepositoryInterface;
use App\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\SaleDetail;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Sale;

class AdminController extends Controller
{
    public $customerRepository;
    
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;

    }

    public function searchEmail(Request $request)
    {
        $customer = Customer::where('email', 'like', $request->email . '%')->select('email', 'name', 'phone', 'address')->limit(10)->get();

        return response()->json(['data' => $customer]);
    }

    public function index(Request $request)
    {
        $keyActived         = License::where('status_register', License::KEY_ACTIVE)->count();
        $keyNotActived      = License::where('status_register', License::KEY_NOT_ACTIVE)->count();
        $queryCustomerCount = DB::select(DB::raw("SELECT COUNT(DISTINCT customer_email) as total from registered"));
        $customerCount = 0;
        if(count($queryCustomerCount) > 0) {
            $customerCount = $queryCustomerCount[0]->total;
        }

        $filters = [
            'license_activation_date' => Carbon::now()->format('Y-m-d')
        ];

        if(!can('customer-view')) {
            $filters['user_support_id'] = auth()->user()->id;
        }
        $day_due = empty($request->day_due) ? 15 : $request->day_due;
        $day_expire = empty($request->day_expire) ? 15 : $request->day_expire;
        $newKeys        = $this->customerRepository->allByFilter($filters, 'id', 'DESC');
        $dateNow = date('Y-m-d');
        $dateDue = date('Y-m-d', strtotime($dateNow. " + $day_due days"));
        $dateExpire = date('Y-m-d', strtotime($dateNow . " - $day_expire days"));
    /**
     * Nếu là admin thì lấy tất cả
     * Ngược lại thì nhân viên của ai người đó chăm sóc
     */
        if (auth()->user()->level == 1) {
            $keyDue = Registered::whereBetween('license_expire_date', [$dateNow, $dateDue])
                                ->paginate(20); // key sắp hết từ 15 ngày trở về
            $keyExpire = Registered::whereBetween('license_expire_date', [$dateExpire, $dateNow])
                                ->paginate(20); // key đã hết hạn 15 ngày hất lại
        } else {
            $keyDue = Registered::where('user_support_id', auth()->user()->id)
                                ->whereBetween('license_expire_date', [$dateNow, $dateDue])
                                ->paginate(20); // key sắp hết từ 15 ngày trở về
            $keyExpire = Registered::where('user_support_id', auth()->user()->id)
                                    ->whereBetween('license_expire_date', [$dateExpire, $dateNow])
                                    ->paginate(20); // key đã hết hạn 15 ngày hất lại
        }

        return view('admin.index.index', compact(
            'keyActived', 'keyNotActived', 'customerCount', 'newKeys', 'keyDue', 'keyExpire', 'day_due', 'day_expire'
        ));
    }

    public function deleteKeyActive($keyId)
    {
        $key = Registered::findOrFail($keyId);
        $key->delete();

        return back()->with('success', 'Xóa thành công');
    }

    public function inputForm()
    {
        $provinces = \DB::table('province')->get();
        $products = Product::all();

        return view('admin.inputs.create', compact('products', 'provinces'));
    }

    public function updateStatusCare(Request $request)
    {
        try {
            if ($request->status == 0) {
                $status_care = 1;
            } else {
                $status_care = 0;
            }
            Registered::whereId($request->id)->update(['status_care' => $status_care]);

            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        }
    }

    public function inputEditForm($id)
    {
        $typeExpireDate = [
            '7'     => '7 Ngày',
            '15'    => '15 Ngày',
            '30'    => '1 Tháng',
            '60'    => '2 Tháng',
            '90'    => '3 Tháng',
            '120'   => '4 Tháng',
            '150'   => '5 Tháng',
            '180'   => '6 Tháng',
            '210'   => '7 Tháng',
            '240'   => '8 Tháng',
            '270'   => '9 Tháng',
            '300'   => '10 Tháng',
            '330'   => '11 Tháng',
            '365'   => '1 Năm',
            '730'   => '2 Năm',
            '1095'  => '3 Năm',
            '1460'  => '4 Năm',
            '1852'  => '5 Năm',
            '3650'  => '10 Năm',
        ];

        $provinces = \DB::table('province')->get();
        $products = Product::all();
        $transaction = Transaction::findOrFail($id);

        return view('admin.inputs.edit', compact('products', 'provinces', 'transaction', 'typeExpireDate'));
    }

    public function inputEdit(Request $request, $id)
    {
        try {
            $inputs = $request->all();
            $transaction = Transaction::findOrFail($id);

            if ($inputs['price'] != $transaction->price) {
                $inputs['price'] = $inputs['price'];
            } else {
                $product = Product::select('price', 'product_type')->where('product_type', $inputs['product_type'])->first();
                $inputs['price'] = $product->price * $inputs['qty'];
            }
            
            $customer = Customer::updateOrCreate(
                ['email' => $inputs['customer_email']],
                [
                    'name' => $inputs['customer_name'],
                    'phone' => $inputs['customer_phone'],
                    'address' => $inputs['customer_address'],
                    'city' => $inputs['customer_cty']
                ]
            );
            $inputs['customer_id'] = $customer->id;
            Transaction::updateOrCreate(
                [
                    'id' => $id
                ],
                $inputs
            );
            if (!empty($request->donate_product)) {
                if ($request->donate_product != "NULL") {
                    $donate_key = 1;
                } else {
                    $donate_key = 0;
                }
                Transaction::updateOrCreate(
                    [
                        'id' => $id
                    ],
                    [
                        'donate_key' => $donate_key
                    ]
                );
            }

            return back()->with('success', 'Đã cập nhật');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }        
    }

    public function getProduct($productId, $count, $total)
    {
        $typeExpireDate = [
            '7'     => '7 Ngày',
            '15'    => '15 Ngày',
            '30'    => '1 Tháng',
            '60'    => '2 Tháng',
            '90'    => '3 Tháng',
            '120'   => '4 Tháng',
            '150'   => '5 Tháng',
            '180'   => '6 Tháng',
            '210'   => '7 Tháng',
            '240'   => '8 Tháng',
            '270'   => '9 Tháng',
            '300'   => '10 Tháng',
            '330'   => '11 Tháng',
            '365'   => '1 Năm',
            '730'   => '2 Năm',
            '1095'  => '3 Năm',
            '1460'  => '4 Năm',
            '1852'  => '5 Năm',
            '3650'  => '10 Năm',
        ];

        $product = Product::findOrFail($productId);
        $type = $product->type;
        $productDonate  = Product::where('type', Product::TYPE_SOFWTWARE)->pluck('name', 'product_type');

        return view('admin.inputs.add_row', ['total' => str_replace(',', '', $total), 'count' => $count, 'type' => $type, 'product' => $product, 'typeExpireDate' => $typeExpireDate, 'productDonate' => $productDonate]);
    }

    public function input(Request $request)
    {
        try {
            $total = str_replace(',', '', $request->total);
            $prepaid = $request->prepaid;
            $customer_phone = $request->customer_phone;
            $customer_email = $request->customer_email;
            $customer_name = $request->customer_name;
            $customer_address = $request->customer_address;
            $customer_cty = $request->customer_cty;
            $user_request_id = auth()->user()->id;
            $note = $request->note;
            $number_day = 365;
            $type = 1;
            $option = NULL;
            $donation_key = 0;
            $donate_product = NULL;
            $so_ngay = $loai_key = $phuong_thuc_hoc = $tang_key = 0;
            $saleId = $this->sale($user_request_id, $customer_name, $customer_phone, $customer_email, $customer_address, $customer_cty, $note, $total, $prepaid);
            
            foreach ($request->product as $key => $productItem) {
                $product_type = $productItem;
                $price = $request->price[$key];
                $discount = $request->discount[$key];
                $amount = $request->amount[$key];
                
                if ($request->product_type[$key] == 0) { //khóa mềm
                    $option = NULL;
                    $number_day = $request->expiry[$so_ngay];
                    $customer_type = 0;
                    $type = $request->type_key[$loai_key];
                    $so_ngay++;$loai_key++;
                    $donate_product = NULL;

                    $transactionId = $this->insertTransaction($user_request_id, $customer_name, $customer_phone, $customer_email, $customer_address, $customer_cty, $product_type, $note, $number_day, $amount, $type, $customer_type, $price, $discount, $option, $donation_key, $donate_product);

                    $this->insertSaleDetail($saleId, $transactionId, $user_request_id, $customer_name, $customer_phone, $customer_email, $customer_address, $customer_cty, $product_type, $note, $number_day, $amount, $type, $customer_type, $price, $discount, $option, $donation_key, $donate_product, $prepaid);

                } else if ($request->product_type[$key] == 1) { // khóa cứng
                    $donate_product = NULL;
                    $customer_type = 1;
                    $option = NULL;
                    $transactionId = $this->insertTransaction($user_request_id, $customer_name, $customer_phone, $customer_email, $customer_address, $customer_cty, $product_type, $note, $number_day, $amount, $type, $customer_type, $price, $discount, $option, $donation_key, $donate_product);

                    $this->insertSaleDetail($saleId, $transactionId, $user_request_id, $customer_name, $customer_phone, $customer_email, $customer_address, $customer_cty, $product_type, $note, $number_day, $amount, $type, $customer_type, $price, $discount, $option, $donation_key, $donate_product, $prepaid);
                } else if ($request->product_type[$key] == 2) { // học viên
                    $customer_type = 2;
                    $option = $request->option_learn[$phuong_thuc_hoc];
                    $donate_product = $request->donation_key[$tang_key];
                    $phuong_thuc_hoc++;
                    $tang_key++;

                    if ($donate_product != "NULL") {
                        $donation_key = 1;
                    } else {
                        $donation_key = 0;
                    }

                    $transactionId = $this->insertTransaction($user_request_id, $customer_name, $customer_phone, $customer_email, $customer_address, $customer_cty, $product_type, $note, $number_day, $amount, $type, $customer_type, $price, $discount, $option, $donation_key, $donate_product);

                    $this->insertSaleDetail($saleId, $transactionId, $user_request_id, $customer_name, $customer_phone, $customer_email, $customer_address, $customer_cty, $product_type, $note, $number_day, $amount, $type, $customer_type, $price, $discount, $option, $donation_key, $donate_product, $prepaid);
                    
                } else if ($request->product_type[$key] == 3) { // chứng chỉ
                    $donate_product = NULL;
                    $customer_type = 3;
                    $option = NULL;
                    $transactionId = $this->insertTransaction($user_request_id, $customer_name, $customer_phone, $customer_email, $customer_address, $customer_cty, $product_type, $note, $number_day, $amount, $type, $customer_type, $price, $discount, $option, $donation_key, $donate_product);

                    $this->insertSaleDetail($saleId, $transactionId,  $user_request_id, $customer_name, $customer_phone, $customer_email, $customer_address, $customer_cty, $product_type, $note, $number_day, $amount, $type, $customer_type, $price, $discount, $option, $donation_key, $donate_product, $prepaid);
                }
            }

            return back()->with('success', 'Thêm thành công');
        } catch (\Throwable $th) {
            echo $th->getMessage() . ': dòng ' . $th->getLine();
        }
    }

    public function insertSaleDetail($saleId, $transactionId,  $user_request_id, $customer_name, $customer_phone, $customer_email, $customer_address, $customer_cty, $product_type, $note, $number_day, $amount, $type, $customer_type, $price, $discount, $method, $donate_key, $donate_product, $prepaid)
    {
        SaleDetail::create([
            'sale_id' => $saleId,
            'transaction_id' => $transactionId,
            'product' => $product_type,
            'product_type' => $customer_type, // loại key: cứng, mềm, chứng chỉ....
            'qty' => $amount, // số lượng
            'number_day' => $number_day, // 1 năm, 2 năm, 7 ngày,....
            'key_type' => $type, // thương mại hoặc thử nghi
            'method' => $method, // online hoặc offline
            'donate_key' => $donate_key,
            'donate_product' => $donate_product,
            'price' => (float)$price
        ]);
    }

    public function sale($user_request_id, $customer_name, $customer_phone, $customer_email, $customer_address, $customer_cty, $note, $total, $prepaid)
    {
        if ($prepaid < $total) {
            $status_prepaid = 1;
        } else {
            $status_prepaid = 0;
        }
        $sale = Sale::create([
            'user_id' => $user_request_id,
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'customer_address' => $customer_address,
            'customer_city' => $customer_cty,
            'note' => $note,
            'total' => (float)$total,
            'prepaid' => $prepaid,
            'status_prepaid' => $status_prepaid
        ]);

        return $sale->id;
    }

    public function insertTransaction($user_request_id, $customer_name, $customer_phone, $customer_email, $customer_address, $customer_cty, $product_type, $note, $number_day, $amount, $type, $customer_type, $price, $discount, $option, $donation_key, $donate_product)
    {
        $customer = Customer::updateOrCreate(
            [
                'email' => $customer_email
            ],[
                'name' => $customer_name,
                'phone' => $customer_phone,
                'address' => $customer_address,
                'city' => $customer_cty,
            ]
        );
        $transaction = Transaction::create(
            [
                'customer_id' => $customer->id,
                'user_request_id' => $user_request_id,
                'product_type' => $product_type,
                'note' => $note,
                'number_day' => $number_day,
                'qty' => $amount,
                'type' => $type,
                'customer_type' => $customer_type,
                'price' => $price,
                'discount' => $discount,
                'option' => $option,
                'donate_key' => $donation_key,
                'donate_product' => $donate_product
            ]
        );

        return $transaction->id;
    }
}

