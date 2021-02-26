<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Product;
use App\Models\Registered;
use App\Permission;
use App\Repositories\CustomerRepositoryInterface;
use App\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class TestController extends Controller
{
    public $customerRepository;
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;

    }

    public function index()
    {
        $product = Product::all();

        dd($product);
    }
}
