<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportLicense;
use App\Exports\ExportLicenseSendEmailToday;
use App\Exports\LicenseAfterCreateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\License\SendKeyRequest;
use App\Http\Requests\Admin\License\StoreRequest;
use App\Http\Requests\Admin\License\UpdateRequest;
use App\Models\Email;
use App\Models\License;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Transaction;
use App\Repositories\LicenseRepositoryInterface;
use App\Services\Production\LicenseService;
use App\Services\Production\MailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Excel;

class ExportLicenseController extends Controller
{

    protected $licenseService;

    protected $licenseRepository;

    public function __construct(
        LicenseService $licenseService,
        LicenseRepositoryInterface $licenseRepository
    )
    {
        $this->licenseService = $licenseService;
        $this->licenseRepository = $licenseRepository;
    }

    public function sendEmailToday()
    {
        return (new ExportLicenseSendEmailToday())->download('danh-sach-key-gui-email-trong-ngay-' . date('d-m-Y') .'.xlsx');
    }
}
