<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportStatistical;
use App\Exports\ExportKpi;
use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Product;
use App\Models\Registered;
use App\Models\Transaction;
use App\Permission;
use App\Repositories\CustomerRepositoryInterface;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    protected $customerRepository;
    public function __construct(
        CustomerRepositoryInterface $customerRepository
    )
    {
        $this->customerRepository = $customerRepository;
    }

    public function region()
    {
        $regions        = Registered::groupBy('customer_cty')->select('customer_cty')->get();
        $productions    = Product::orderBy('id', 'ASC')->get();
        $productionsPL  = Product::orderBy('id', 'ASC')->pluck('product_type');

        $resultsValue = [];
        foreach($regions as $region) {
            $countByProduct = Registered::whereIn('product_type', $productionsPL)
                                ->where('customer_cty', $region->customer_cty)
                                ->groupBy('product_type', 'customer_cty')
                                ->select(['product_type',DB::raw('count(*) as total')])->get();

            $resultCount = [];
            foreach($productions as $prdt) {
                $resultCount[$prdt->name] = 0;
                foreach($countByProduct as $count) {
                    if($prdt->product_type == $count->product_type)
                        $resultCount[$prdt->name] = $count->total;
                }
            }

            $resultsValue[] = array_values($resultCount);
        }

        return view('admin.chart.region', compact(
            'regions',
            'productions',
            'resultsValue'
        ));
    }

    public function users(Request $request)
    {
        $inputs = $request->only([
            'month', 'year'
        ]);

        $month  = (!empty($inputs['month']))    ? $inputs['month']  : date('m');
        $year   = (!empty($inputs['year']))     ? $inputs['year']   : date('Y');

        $startDate  = date('Y-m-01 00:00:00', strtotime($year . '-' . $month));
        $endDate    = date('Y-m-t 23:59:00', strtotime($year . '-' . $month));

        $users      = User::all();
        $products   = Product::orderBy('type', 'ASC')->get();

        $transactions = Transaction::where('status', 1)
            ->where('customer_type', 0)
            ->where('type', 1)
            ->where('free', 0)
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->groupBy(['product_type', 'user_request_id'])
            ->select([
                DB::raw('SUM(qty) as qty'),
                'product_type',
                'user_request_id',
            ])
            ->get();

        $haskey = Transaction::where('status', 1)
            ->where('customer_type', 1)
            ->where('type', 1)
            ->where('free', 0)
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->groupBy(['product_type', 'user_request_id'])
            ->select([
                DB::raw('SUM(qty) as qty'),
                'product_type',
                'user_request_id',
            ])
            ->get();


        $course = Transaction::where('status', 1)
            ->where('customer_type', 2)
            ->where('type', 1)
            ->where('free', 0)
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->groupBy(['product_type', 'user_request_id'])
            ->select([
                DB::raw('SUM(qty) as qty'),
                'product_type',
                'user_request_id',
            ])
            ->get();

        $productArr = [];
        foreach ($products as $pr) {
            $productArr[$pr->product_type] = [
                'product_type'  => $pr->product_type,
                'name'          => $pr->name,
                'qty'           => 0,
                'price'         => $pr->price,
                'discount'      => $pr->discount,
            ];
        }

        $datas = [];
        foreach($users as $user) {
            $datas['u_' . $user->id] = [
                    'id'        => $user->id,
                    'fullname'  => $user->fullname,
                    'email'     => $user->email,
                    'avatar'    => $user->avatar,
                    'products'  => $productArr
                ];
        }

        foreach($haskey as $hash) {
            $datas['u_' . $hash->user_support_id]['products'][$hash->product_type]['qty'] += $hash->qty;
        }

        foreach($transactions as $transaction) {
            $datas['u_' . $transaction->user_request_id]['products'][$transaction->product_type]['qty'] += $transaction->qty;
        }

        foreach($course as $cs) {
            $datas['u_' . $cs->user_request_id]['products'][$cs->product_type]['qty'] += $cs->qty;
        }

        return view('admin.chart.user', compact('datas'));
    }

//    public function usersDetail(Request $request)
//    {
//        $inputs = $request->only([
//            'month', 'year', 'user_id'
//        ]);
//
//        $month  = (!empty($inputs['month']))    ? $inputs['month']  : date('m');
//        $year   = (!empty($inputs['year']))     ? $inputs['year']   : date('Y');
//        $userID = (!empty($inputs['user_id'])) ? $inputs['user_id'] : 9999999999999;
//
//        $startDate  = date('Y-m-01 00:00:00', strtotime($year . '-' . $month));
//        $endDate    = date('Y-m-t 23:59:00', strtotime($year . '-' . $month));
//
//        $users      = User::all();
//        $products   = Product::orderBy('type', 'ASC')->get();
//
//        $transactions = Transaction::where('status', 1)
//            ->where('customer_type', 0)
//            ->where('user_request_id', $userID)
//            ->where('type', 1)
//            ->where('free', 0)
//            ->whereBetween('updated_at', [$startDate, $endDate])
//            ->groupBy(['product_type'])
//            ->select([
//                DB::raw('SUM(qty) as qty'),
//                'product_type'
//            ])
//            ->get();
//
//
//        $haskey = Transaction::where('status', 1)
//            ->where('customer_type', 1)
//            ->where('user_request_id', $userID)
//            ->where('type', 1)
//            ->where('free', 0)
//            ->whereBetween('updated_at', [$startDate, $endDate])
//            ->groupBy(['product_type'])
//            ->select([
//                DB::raw('SUM(qty) as qty'),
//                'product_type'
//            ])
//            ->get();
//
//        $course = Transaction::where('status', 1)
//            ->where('customer_type', 2)
//            ->where('user_request_id', $userID)
//            ->where('type', 1)
//            ->where('free', 0)
//            ->whereBetween('updated_at', [$startDate, $endDate])
//            ->groupBy(['product_type'])
//            ->select([
//                DB::raw('SUM(qty) as qty'),
//                'product_type'
//            ])
//            ->get();
//
//
//        $datas = [];
//        foreach ($products as $pr) {
//            $datas[$pr->product_type] = [
//                'product_type'  => $pr->product_type,
//                'name'          => $pr->name,
//                'qty'           => 0,
//                'price'         => $pr->price,
//                'discount'      => $pr->discount,
//            ];
//        }
//
//        foreach($haskey as $hash) {
//            $datas[$hash->product_type]['qty'] += $hash->qty;
//        }
//
//        foreach($transactions as $transaction) {
//            $datas[$transaction->product_type]['qty'] += $transaction->qty;
//        }
//
//        foreach($course as $cs) {
//            $datas[$cs->product_type]['qty'] += $cs->qty;
//        }
//
//
//        $i = 0;
//        foreach ($datas as $data) {
//            if($datas[$data['product_type']]['qty'] == 0) {
//                unset($datas[$data['product_type']]);
//            }
//            $i++;
//        }
//
//        return view('admin.chart.user_detail', compact('datas', 'users'));
//    }

    public function usersDetail(Request $request)
    {                
    /* Code cũ
        $inputs = $request->only([
            'month', 'year', 'user_id'
        ]);

        $month  = (!empty($inputs['month']))    ? $inputs['month']  : date('m');
        $year   = (!empty($inputs['year']))     ? $inputs['year']   : date('Y');
        $userID = (!empty($inputs['user_id'])) ? $inputs['user_id'] : 9999999999999;

        $startDate  = date('Y-m-01 00:00:00', strtotime($year . '-' . $month));
        $endDate    = date('Y-m-t 23:59:00', strtotime($year . '-' . $month));
    */

    /* Code mới của CHÍNH */
        $inputs = $request->only([
            'date', 'user_id'
        ]);
        
        if (!empty($inputs['date'])) {
            $startDate = trim(explode('-', $inputs['date'])[0]);
            $startDate = str_replace('/', '-', $startDate);
            $startDate = date('Y-m-d 00:00:00', strtotime($startDate));

            $endDate = trim(explode('-', $inputs['date'])[1]);
            $endDate = str_replace('/', '-', $endDate);
            $endDate = date('Y-m-d 23:59:00', strtotime($endDate));
        } else {
            $startDate = date('Y-m-d 00:00:00');
            $endDate = date('Y-m-d 23:59:00');
        }


        if (!empty($inputs['user_id'])) {
            $userID = $inputs['user_id'];
        } else {
            $userID = 9999999999;
        }
        $users      = User::all();
        $products   = Product::orderBy('type', 'ASC')->get();
        // Điều kiện lọc thống kê tất cả các đơn hàng
        if ($request->submit == 'export') {
            return (new ExportStatistical(
                $userID,
                $startDate,
                $endDate
            ))->download('list-license-export-'.date('d-m-Y').'.xlsx');
        }

        if ($userID == -1) {
            $transactions = Transaction::where('status', 1)
            //->where('customer_type', 3) //Có 4 loại 0, 1, 2, 3
            ->where('free', 0)
            ->whereBetween('time_approve', [$startDate, $endDate])
            ->with(['product'])
            ->latest()
            ->get();
            $transactionsTotal = Transaction::where('status', 1)
            //->where('customer_type', 3) //Có 4 loại 0, 1, 2, 3
            ->where('free', 0)
            ->whereBetween('time_approve', [$startDate, $endDate])
            ->with(['product'])
            ->get()->groupBy(['product_type']);
        } else {
            $transactions = Transaction::where('status', 1)
            //->where('customer_type', 3) //Có 4 loại 0, 1, 2, 3
            ->where('user_request_id', $userID)
            ->where('free', 0)
            ->whereBetween('time_approve', [$startDate, $endDate])
            ->with(['product'])
            ->latest()
            ->get();

            $transactionsTotal = Transaction::where('status', 1)
            //->where('customer_type', 3) //Có 4 loại 0, 1, 2, 3
            ->where('user_request_id', $userID)
            ->where('free', 0)
            ->whereBetween('time_approve', [$startDate, $endDate])
            ->with(['product'])
            ->get()->groupBy('product_type');
        }
        $stt = 0;
        //dd($transactionsTotal);
            
        return view('admin.statistic.user_detail', compact('transactions', 'users', 'userID', 'transactionsTotal', 'stt', 'inputs'));
    }

    public function usersDetailDelete($id)
    {
        if (auth()->user()->level == 1) {
            $transaction = Transaction::findOrFail($id);

            if ($transaction->customer_type == 0) {
                $transaction->delete();

                return back()->with('succes', 'Xóa thành công');
            } else {
                $transaction->delete();

                if (!empty($transaction->registered)) {
                    $transaction->registered->delete;
                }

                return back()->with('succes', 'Xóa thành công');
            }
        } else {
            return back()->with('error', 'Bạn không đủ quyền xóa');
        }
    }

    public function expiredCustomer(Request $request)
    {
        $inputs = $request->only([
            'query', 'product_type','date','customer_cty', 'use_date', 'day'
        ]);

        $filters = [
            'khoamem' => true,
            'expired_day' => 1,
        ];

        if(!empty($inputs['day'])) {
            $filters['expired_day'] = $inputs['day'];
        }

        $filters['expired_day'] = Carbon::now()->addDays('-' . $filters['expired_day'])->format('Y-m-d');
        if(!can('customer-view')) {
            $filters['user_support_id'] = auth()->user()->id;
        }

        $customers      = $this->customerRepository->filterPagination($filters, '20', 'id', 'DESC');
        $productTypes   = Product::where('type', Product::TYPE_SOFWTWARE)->get();
        $provinces      = Registered::groupBy(['customer_cty'])->select(['customer_cty'])->get();
        $users          = User::all();
        $listDay = [1,3,5,7,30];

        return view('admin.chart.expired_customer', compact(
            'customers', 'productTypes', 'inputs', 'provinces', 'users', 'listDay'
        ));
    }

    public function expiredBeforeCustomer(Request $request)
    {
        $inputs = $request->only([
            'query', 'product_type','date','customer_cty', 'use_date', 'day'
        ]);

        $filters = [
            'khoamem' => true,
            'before_expired_day' => 1,
        ];

        if(!empty($inputs['day'])) {
            $filters['before_expired_day'] = $inputs['day'];
        }

        $filters['before_expired_day'] = Carbon::now()->addDays($filters['before_expired_day'])->format('Y-m-d');
        if(!can('customer-view')) {
            $filters['user_support_id'] = auth()->user()->id;
        }

        $customers      = $this->customerRepository->filterPagination($filters, '20', 'id', 'DESC');
        $productTypes   = Product::where('type', Product::TYPE_SOFWTWARE)->get();
        $provinces      = Registered::groupBy(['customer_cty'])->select(['customer_cty'])->get();
        $users          = User::all();
        $listDay = [
            1   => '1 Ngày',
            3   => '3 Ngày',
            5   => '5 Ngày',
            7   => 'Trong tuần',
            30  => 'Trong tháng',
        ];

        return view('admin.chart.before_expired_customer', compact(
            'customers', 'productTypes', 'inputs', 'provinces', 'users', 'listDay'
        ));
    }

    public function courseLicense()
    {
        $licenses = License::whereHas('transaction')->with(['transaction', 'product', 'transaction.product'])->paginate();
        return view('admin.chart.course-license', compact(
            'licenses'
        ));

    }
    public function kpi(Request $request)
    {
        try {
            $users = User::all();
            $month = (!empty($request->month) ? $request->month : date('m'));
            $year = (!empty($request->year) ? $request->year : date('Y'));

            if ($month == 100) {
                $type = 0; //cả năm
            } else {
                $type = 1; //theo tháng
            }
            $date = $year . '-' . $month;

            if (!empty($request->submit) && $request->submit == 'export') {
                return (new ExportKpi($users, $month, $year, $date, $type))->download('kpi-' . Carbon::now()->format('Y-m-d').'.xlsx');
            }

            return view('admin.chart.kpi', compact('users', 'month', 'year', 'date', 'type'));
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
