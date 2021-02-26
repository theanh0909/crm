<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportCustomer;
use App\Exports\ExportCustomerBeforeExpired;
use App\Exports\ExportCustomerExpired;
use App\Exports\ExportCustomerNotPaid;
use App\Exports\ExportCustomerTrial;
use App\Exports\ExportHashkey;
use App\Http\Controllers\Controller;
use App\Imports\ImportHashkeyCustomer;
use App\Models\Email;
use App\Models\License;
use App\Models\Product;
use App\Models\Registered;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\LicenseRepositoryInterface;
use App\Services\Production\MailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ExportCustomerController extends Controller
{
    protected $customerRepository;

    protected $licenseRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        LicenseRepositoryInterface $licenseRepository
    )
    {
        $this->customerRepository = $customerRepository;
        $this->licenseRepository = $licenseRepository;
    }

    public function notPaid(Request $request)
    {
        $dateFrom   = $request->date_from;
        $dateTo     = $request->date_to;

        return (new ExportCustomerNotPaid($dateFrom, $dateTo))->download('danh-sach-khach-hang-chua-thanh-toan-'.$dateFrom. '-' . $dateTo .'.xlsx');
    }

    public function expired(Request $request)
    {
        $day   = $request->day;
        return (new ExportCustomerExpired($day))->download('danh-sach-khach-hang-da-het-han-'.$day. '-ngay-' . date('d-m-Y') .'.xlsx');
    }

    public function beforeExpired(Request $request)
    {
        $day   = $request->day;
        return (new ExportCustomerBeforeExpired($day))->download('danh-sach-khach-hang-sap-het-han-'.$day. '-ngay-' . date('d-m-Y') .'.xlsx');
    }

}
