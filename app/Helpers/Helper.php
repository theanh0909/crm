<?php

namespace app\Helpers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\License;

class Helper
{
    public static function getProductName($type)
    {
        return Product::where('product_type', $type)->first();
    }

    public static function statisticProduct($dateStart, $dateEnd, $productType)
    {
        $inputPrice = $outputPrice = $profit = 0;
        $transactions = Transaction::where('status', 1)
                                        ->where('product_type', $productType)
                                        ->whereDate('time_approve', '>=', $dateStart)
                                        ->whereDate('time_approve', '<=', $dateEnd)
                                        ->get();
        
        foreach ($transactions as $item) {
            $inputPrice+= $item->price * $item->qty;
            $outputPrice+= $item->product->input_price * $item->qty;
            $profit+= ($item->price * $item->qty - $item->product->input_price * $item->qty) * $item->product->discount/100;
        }

        return [
            'inputPrice' => number_format($inputPrice),
            'outputPrice' => number_format($outputPrice),
            'profit' => number_format($profit)
        ];
    }

    public static function statisticUser($userId, $startDate, $endDate)
    {
        $inputPrice = $outputPrice = $profit = 0;

        if ($userId == -1) {
            $transactions = Transaction::where('status', 1)
                                        ->whereDate('time_approve', '>=', $startDate)
                                        ->whereDate('time_approve', '<=', $endDate)
                                        ->get();
        } else {
            $transactions = Transaction::where('user_request_id', $userId)
                                        ->where('status', 1)
                                        ->whereDate('time_approve', '>=', $startDate)
                                        ->whereDate('time_approve', '<=', $endDate)
                                        ->get();
        }
        
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

    public static function getKpi($date, $userId, $type, $year)
    {
        $vace = $vacc = 0;

        if ($type == 0) {
            // kpi theo cả năm
            $transactions = Transaction::where('user_request_id', $userId)
                                    ->where('status', 1)
                                    ->whereYear('time_approve', $year)
                                    ->get();
            $total = 0;

            foreach ($transactions as $transactionItem) {
                
                if (strpos($transactionItem->product_type, 'hnt') >= 0) {
                    $vacc+= ($transactionItem->product) ? $transactionItem->product->input_price : 0;
                } else if (strpos($transactionItem->product_type, 'kte') >= 0) {
                    $vace+= ($transactionItem->product) ? $transactionItem->product->input_price : 0;
                }
                $total = $total + $transactionItem->price * $transactionItem->qty;
            }
        } else if ($type == 1) {
            // kpi theo tháng đã chọn
            $transactions = Transaction::where('user_request_id', $userId)
                                    ->where('status', 1)
                                    ->where('time_approve', 'like', $date . '%')
                                    ->get();
            $total = 0;

            foreach ($transactions as $transactionItem) {
                if (strpos($transactionItem->product_type, 'hnt') >= 0) {
                    $vacc+= ($transactionItem->product) ? $transactionItem->product->input_price : 0;
                } else if (strpos($transactionItem->product_type, 'kte') >= 0) {
                    $vace+= ($transactionItem->product) ? $transactionItem->product->input_price : 0;
                }
                $total = $total + $transactionItem->price * $transactionItem->qty;
            }
        }
        
        return [
            'total' => $total,
            'vacc' => $vacc,
            'vace' => $vace
        ];
    }

    public static function checkKeyNotActive($license_key)
    {
        $license = License::where('license_key', $license_key)->first();

        if (!empty($license)) {
            return $license->hardware_id;
        }
    }

    public static function vaccTotal($dateStart, $dateEnd)
    {
        $transactions = Transaction::where('product_type', 'like', 'hnt%')
                                    ->where('status', 1)
                                    ->whereBetween('time_approve', [$dateStart, $dateEnd])
                                    ->get();
        $total = 0;

        foreach ($transactions as $transactionItem) {
            $total = $total + $transactionItem->product->input_price * $transactionItem->qty;
        }

        return number_format($total);
    }

    public static function vaceTotal($dateStart, $dateEnd)
    {
        $transactions = Transaction::where('product_type', 'like', 'kte%')
                                    ->where('status', 1)
                                    ->whereBetween('time_approve', [$dateStart, $dateEnd])
                                    ->get();
        $total = 0;

        foreach ($transactions as $transactionItem) {
            $total = $total + $transactionItem->product->input_price * $transactionItem->qty;
        }

        return number_format($total);
    }

    
    public static function countKey($product_type, $status) {
		return License::select('product_type', 'status', 'hardware_id', 'status', 'email_customer')
                        ->where('hardware_id', 'NA')
                        ->where('product_type', $product_type)
                        ->where('status', $status)
						->whereNull('email_customer')
						->count();
	}
}