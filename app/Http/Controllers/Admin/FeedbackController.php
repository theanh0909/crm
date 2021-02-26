<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\ProductType;
use App\Http\Requests\Admin\ProductType\StoreRequest;
use App\Http\Requests\Admin\ProductType\UpdateRequest;
use Mockery\Exception;

class FeedbackController extends Controller
{
    public function index()
    {
        $models = Feedback::with(['customer'])->paginate(20);
        return view('admin.feedback.index', compact(
            'models'
        ));
    }

}
