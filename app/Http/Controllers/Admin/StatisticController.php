<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportVacc;
use App\Exports\ExportVace;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\ExportStatistical;
use App\Exports\ExportStatisticalAll;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\License;
use App\Models\Product;
use App\Models\Registered;
use App\Models\Transaction;
use App\Permission;
use App\Repositories\CustomerRepositoryInterface;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;

class StatisticController extends Controller
{
    public function product(Request $request)
    {
        $transactions = [];
        $data = [
            'inputPrice' => '',
            'outputPrice' => '',
            'profit' => ''
        ];
        $inputs = [
            'product' => '',
            'date' => date('d/m/Y') . '-' . date('d/m/Y'),
        ];
        
        if (!empty($request->product) && $request->product != '') {
            $inputs['product'] = $request->product;
        }
        if (!empty($request->date)) {
            $inputs['date'] = $request->date;
        }
        $dateStart = trim(explode('-', $inputs['date'])[0]);
        $dateStart = str_replace('/', '-', $dateStart);
        $dateStart = date('Y-m-d', strtotime($dateStart));

        $dateEnd = trim(explode('-', $inputs['date'])[1]);
        $dateEnd = str_replace('/', '-', $dateEnd);
        $dateEnd = date('Y-m-d', strtotime($dateEnd));
        if ($request->submit == 'thongke') {
            //DB::enableQueryLog();
            $transactions = Transaction::where('status', 1)
                                        ->where('product_type', $inputs['product'])
                                        ->whereDate('time_approve', '>=', $dateStart)
                                        ->whereDate('time_approve', '<=', $dateEnd)
                                        ->latest()
                                        ->get();
            $data = $this->statisticProduct($dateStart, $dateEnd, $transactions);
            $transactions = $this->paginate($transactions, 20);
            $transactions->withPath(url()->current());
            
        }
        $productType = $inputs['product'];
        $products = Product::all();
        

        return view("admin.statistic.product", compact('productType', 'products', 'transactions', 'dateStart', 'dateEnd', 'data'));
    }
    public function time()
    {
        return view("admin.statistic.time");
    }
    public function local()
    {
        return view("admin.statistic.local");
    }
    public function vace(Request $request)
    {
        if (!empty($request->submit) && $request->submit == 'export') {
            $date = $request->date;
            $dateStart = trim(explode('-', $date)[0]);
            $dateStart = str_replace('/', '-', $dateStart);
            $dateStart = date('Y-m-d 00:00:00', strtotime($dateStart));

            $dateEnd = trim(explode('-', $date)[1]);
            $dateEnd = str_replace('/', '-', $dateEnd);
            $dateEnd = date('Y-m-d 23:59:00', strtotime($dateEnd));

            $startDateExport = date('d-m-Y', strtotime($dateStart));
            $endDateExport = date('d-m-Y', strtotime($dateEnd));

            return (new ExportVace($dateStart, $dateEnd))->download('export-vace-' . $startDateExport . '-' . $endDateExport .'.xlsx');
        }

        $day_num = date('t');

        if (empty($request->date)) {
            $dateStart = date('Y-m-01 00:00:00');
            $dateEnd = date("Y-m-$day_num 23:59:00");
        } else {
            $date = $request->date;
            $dateStart = trim(explode('-', $date)[0]);
            $dateStart = str_replace('/', '-', $dateStart);
            $dateStart = date('Y-m-d 00:00:00', strtotime($dateStart));

            $dateEnd = trim(explode('-', $date)[1]);
            $dateEnd = str_replace('/', '-', $dateEnd);
            $dateEnd = date('Y-m-d 23:59:00', strtotime($dateEnd));
        }
        $dateStartToView = date('Y/m/d', strtotime($dateStart));
        $dateEndToView = date('Y/m/d', strtotime($dateEnd));
        $customer_name = $request->customer_name;

        if ($customer_name == '') {
            $transactions = Transaction::where('product_type', 'like', 'kte%')
                                    ->where('status', 1)
                                    ->whereBetween('time_approve', [$dateStart, $dateEnd])
                                    ->paginate(20);
        } else {
            $transactions = Transaction::where('product_type', 'like', 'kte%')
                                        ->where('customer_name', 'like', '%' . $customer_name . '%')
                                        ->where('status', 1)
                                        ->paginate(20);
        }
        
        return view('admin.statistic.vace', compact('customer_name', 'transactions', 'dateStartToView', 'dateEndToView'));
    }

    public function editNote(Request $request)
    {
        try {
            $id = $request->id;
            $note = $request->note;
            Transaction::where('id', $id)->update(['note' => $note]);

            return response()->json(true);
        } catch (\Throwable $th) {
            return response()->json(false);
        }
        
    }

    public function updateStatus(Request $request)
    {
        try {
            $inputs = $request->all();

            if ($inputs['type'] == 'vacc') {
                if ($inputs['id'] != '') {
                    Transaction::where('id', $inputs['id'])->update(['status_vacc' => $inputs['status']]);
                } else {
                    $transactions = Transaction::where('product_type', 'like', 'hnt%')
                                        ->where('status', 1)
                                        ->whereDate('time_approve', '>=', $inputs['date_start'])
                                        ->whereDate('time_approve', '<=', $inputs['date_end'])
                                        ->update(['status_vacc' => $inputs['status']]);
                }
                
            } else if ($inputs['type'] == 'vace') {
                if ($inputs['id'] != '') {
                    Transaction::where('id', $inputs['id'])->update(['status_vace' => $inputs['status']]);
                } else {
                    $transactions = Transaction::where('product_type', 'like', 'kte%')
                                        ->where('status', 1)
                                        ->whereDate('time_approve', '>=', $inputs['date_start'])
                                        ->whereDate('time_approve', '<=', $inputs['date_end'])
                                        ->update(['status_vace' => $inputs['status']]);
                }
            }
            
            return response()->json('true');
        } catch (\Throwable $th) {
            return response()->json('false');
        }                            
    }

    public function vacc(Request $request)
    {       
        try {
            if (!empty($request->submit) && $request->submit == 'export') {
                $date = $request->date;
                $dateStart = trim(explode('-', $date)[0]);
                $dateStart = str_replace('/', '-', $dateStart);
                $dateStart = date('Y-m-d 00:00:00', strtotime($dateStart));

                $dateEnd = trim(explode('-', $date)[1]);
                $dateEnd = str_replace('/', '-', $dateEnd);
                $dateEnd = date('Y-m-d 23:59:00', strtotime($dateEnd));

                $startDateExport = date('d-m-Y', strtotime($dateStart));
                $endDateExport = date('d-m-Y', strtotime($dateEnd));
                return (new ExportVacc($dateStart, $dateEnd))->download('export-vacc-' . $startDateExport . '-' . $endDateExport .'.xlsx');
            }       
            $day_num = date('t');

            if (empty($request->date)) {
                $dateStart = date('Y-m-01 00:00:00');
                $dateEnd = date("Y-m-$day_num 23:59:00");
            } else {
                $date = $request->date;
                $dateStart = trim(explode('-', $date)[0]);
                $dateStart = str_replace('/', '-', $dateStart);
                $dateStart = date('Y-m-d 00:00:00', strtotime($dateStart));

                $dateEnd = trim(explode('-', $date)[1]);
                $dateEnd = str_replace('/', '-', $dateEnd);
                $dateEnd = date('Y-m-d 23:59:00', strtotime($dateEnd));
            }
            //dd($dateEnd);
            $dateStartToView = date('Y/m/d', strtotime($dateStart));
            $dateEndToView = date('Y/m/d', strtotime($dateEnd));
            $customer_name = $request->customer_name;

            if ($customer_name == '') {
                $transactions = Transaction::where('product_type', 'like', 'hnt%')
                                        ->where('status', 1)
                                        ->whereBetween('time_approve', [$dateStart, $dateEnd])
                                        ->paginate(20);
            } else {
                $transactions = Transaction::where('product_type', 'like', 'hnt%')
                                            ->where('customer_name', 'like', '%' . $customer_name . '%')
                                            ->where('status', 1)
                                            ->paginate(20);
            }
            
            return view('admin.statistic.vacc', compact('customer_name', 'transactions', 'dateStartToView', 'dateEndToView'));
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    
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
            'date', 'user_id', 'customer_type'
        ]);
        $transactions = [];
        $transactionsTotal = [];
        $data = [
            'inputPrice' => '',
            'outputPrice' => '',
            'profit' => ''
        ];
        
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
        $date = date('d/m/Y', strtotime($startDate)) . ' - ' . date('d/m/Y', strtotime($endDate));

        if (!empty($inputs['user_id'])) {
            $userID = $inputs['user_id'];
        } else {
            $userID = -1;
        }
        $users      = User::all();
        $products   = Product::orderBy('type', 'ASC')->get();
        $between = [0, 3];
        $customerType = 4;

        if (isset($inputs['customer_type'])) {
            $type = (int)$inputs['customer_type'];

            if ($type < 4) {
                $between = [$type, $type];
                $customerType = $type;
            }
        }

        // Điều kiện lọc thống kê tất cả các đơn hàng
        if ($request->submit == 'export') {
            $startDateExport = date('d-m-Y', strtotime($startDate));
            $endDateExport = date('d-m-Y', strtotime($endDate));
            return (new ExportStatistical(
                $userID,
                $startDate,
                $endDate,
                $between
            ))->download(auth()->user()->fullname . '-' . $startDateExport . '-' . $endDateExport .'.xlsx');
        }

        if ($userID == -1) {
            $transactions = Transaction::where('status', 1)
                                        //->where('customer_type', 3) //Có 4 loại 0, 1, 2, 3
                                        ->where('free', 0)
                                        ->whereBetween('time_approve', [$startDate, $endDate])
                                        ->whereBetween('customer_type', $between)
                                        ->with(['product'])
                                        ->latest('customer_type')
                                        ->get();
            $data = $this->statisticUser($startDate, $endDate, $transactions);
            $transactionsTotal = Transaction::where('status', 1)
                                        ->where('free', 0)
                                        ->whereBetween('time_approve', [$startDate, $endDate])
                                        ->whereBetween('customer_type', $between)
                                        ->with(['product'])
                                        ->get()->groupBy(['product_type']);
            $transactions = $this->paginate($transactions, 20);
            $transactions->withPath(url()->current());
        } else if ($userID > 1) {
            $transactions = Transaction::where('status', 1)
                                    ->where('user_request_id', $userID)
                                    ->where('free', 0)
                                    ->whereBetween('time_approve', [$startDate, $endDate])
                                    ->whereBetween('customer_type', $between)
                                    ->with(['product'])
                                    ->latest('customer_type')
                                    ->get();
            $data = $this->statisticUser($startDate, $endDate, $transactions);

            $transactionsTotal = Transaction::where('status', 1)
                                            ->where('user_request_id', $userID)
                                            ->where('free', 0)
                                            ->whereBetween('time_approve', [$startDate, $endDate])
                                            ->whereBetween('customer_type', $between)
                                            ->with(['product'])
                                            ->get()->groupBy('product_type');
            $transactions = $this->paginate($transactions, 20);
            $transactions->withPath(url()->current());
        }
        
        $stt = 0;
        //dd($data);
        //dd($transactiotransactionsnsTotal);
            
        return view('admin.statistic.user_detail', compact('customerType', 'transactions', 'users', 'userID', 'transactionsTotal', 'stt', 'inputs', 'startDate', 'endDate', 'date', 'data'));
    }

    public function paginate($items, $perPage = 30, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function statisticUser($startDate, $endDate, $transactions)
    {        
        $inputPrice = $outputPrice = $profit = 0;

        foreach ($transactions as $item) {
            if (!empty($item->product)) {
                $discount = $item->product->discount;
                $input_price = $item->product->input_price;
            } else {
                $discount = 0;
                $input_price = 0;
            }
            $inputPrice+= $item->price * $item->qty;
            $outputPrice+= $input_price * $item->qty;
            $profit+= ($item->price * $item->qty - $input_price * $item->qty) * $discount/100;
        }

        return [
            'inputPrice' => number_format($inputPrice),
            'outputPrice' => number_format($outputPrice),
            'profit' => number_format($profit)
        ];
    }

    public function statisticProduct($startDate, $endDate, $transactions)
    {        
        $inputPrice = $outputPrice = $profit = 0;

        foreach ($transactions as $item) {
            $sl = $item->qty;
            $discount = ($item->product) ? $item->product->discount : 0;
            $input_price = ($item->product) ? $item->product->input_price : 0;

            $inputPrice+= $item->price * $sl;
            $outputPrice+= $input_price * $sl;
            $profit+= ($item->price * $sl - $input_price * $sl) * $discount/100;
        }

        return [
            'inputPrice' => number_format($inputPrice),
            'outputPrice' => number_format($outputPrice),
            'profit' => number_format($profit)
        ];
    }

    public function updateSalaryItem(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        Transaction::where('id', $id)->update(['status_salary' => $status]);
    }

    public function updateCertificateItem(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        Transaction::where('id', $id)->update(['status_certificate' => $status]);
    }

    public function updateSalary(Request $request)
    {
        $status_salary = $request->status_salary;
        $startDate = trim(explode('-', $request->date)[0]);
        $startDate = \str_replace('/', '-', $startDate);
        $startDate = date('Y-m-d 00:00:00', strtotime($startDate));

        $endDate = trim(explode('-', $request->date)[1]);
        $endDate = str_replace('/', '-', $endDate);
        $endDate = date('Y-m-d 23:59:00', strtotime($endDate));

        Transaction::where('status', 1)->where('free', 0)
                                       ->whereBetween('time_approve', [$startDate, $endDate])
                                       ->update(['status_salary' => $status_salary]);
    }

    public function consolidated(Request $request)
    {
        $inputs = $request->only([
            'date'
        ]);
        
        if (!empty($inputs['date'])) {
            $startDate = trim(explode('-', $inputs['date'])[0]);
            $startDate = str_replace('/', '-', $startDate);
            $startDate = date('Y-m-d 00:00:00', strtotime($startDate));

            $endDate = trim(explode('-', $inputs['date'])[1]);
            $endDate = str_replace('/', '-', $endDate);
            $endDate = date('Y-m-d 23:59:00', strtotime($endDate));
        } else {
            $startDate = date('Y-m-01 00:00:00');
            $endDate = date('Y-m-31 23:59:00');
        }
        // Điều kiện lọc thống kê tất cả các đơn hàng
        if ($request->submit == 'export') {
            $startDateExport = date('d-m-Y', strtotime($startDate));
            $endDateExport = date('d-m-Y', strtotime($endDate));
            return Excel::download(new ExportStatisticalAll(
                $startDate,
                $endDate
            ), 'lam-luong-' . $startDateExport . '-' . $endDateExport . '.xlsx');
        }
        $customer_name = $request->customer_name;
        
        if ($customer_name == '') {
            $transactions = Transaction::where('status', 1)
                                    ->where('free', 0)
                                    ->whereBetween('time_approve', [$startDate, $endDate])
                                    ->with(['product'])
                                    ->latest()
                                    ->paginate(40);
            $transactionsTotal = Transaction::where('status', 1)
                                        ->where('free', 0)
                                        ->whereBetween('time_approve', [$startDate, $endDate])
                                        ->with(['product'])
                                        ->get();
        } else {
            $transactions = Transaction::where('status', 1)
                                    ->where('free', 0)
                                    ->where('customer_name', 'like', '%' . $customer_name . '%')
                                    ->with(['product'])
                                    ->latest()
                                    ->paginate(40);
            $transactionsTotal = Transaction::where('status', 1)
                                        ->where('free', 0)
                                        ->where('customer_name', 'like', '%' . $customer_name . '%')
                                        ->with(['product'])
                                        ->get();
        }
        
        $outputPriceTotal = 0;
        $inputPriceTotal = 0;
        $profitTotal = 0;

        foreach($transactionsTotal as $key => $item) {
            $outputPriceTotal = $outputPriceTotal + $item->product->input_price; // tiền ra phải trả cho hội
            $inputPriceTotal = $inputPriceTotal + $item->price * $item->qty; // tiền nhận từ khách
            $profitTotal= $profitTotal + (($item->price * $item->qty - $item->product->input_price) * $item->product->discount/100);
        }
        
        $stt = 0;
            
        return view('admin.statistic.user_consolidated', compact('customer_name', 'transactions', 'stt', 'startDate', 'endDate', 'profitTotal', 'inputPriceTotal', 'outputPriceTotal'));
    }
}
