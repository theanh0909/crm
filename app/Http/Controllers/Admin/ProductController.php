<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Models\ProductType;
use App\Repositories\ProductRepositoryInterface;
use App\Services\FileUploadServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class ProductController extends Controller
{
    const PRODUCT_ICON_UPLOAD_PACH = 'product';

    protected $productRepository;

    protected $fileUploadService;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        FileUploadServiceInterface $fileUploadService
    )
    {
        $this->productRepository        = $productRepository;
        $this->fileUploadService        = $fileUploadService;
    }


    public function index(Request $request)
    {
        $inputs = $request->only([
            'query'
        ]);
        $filters = [];
        if(!empty($inputs['query'])) {
            $filters['query'] = $inputs['query'];
        }

        $models = $this->productRepository->filterPagination($filters, 10);

        return view('admin.product.index', compact('models'));
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(StoreRequest $request)
    {
        $inputs = $request->only([
            'name',
            'price',
            'product_type',
            'version',
            'key_version',
            'description',
            'number_of_change',
            'discount',
            'type',
            'status',
            'input_price',
            'api',
        ]);

        $file = $request->file('icon');
        if($file) {
            $dataUpload = Storage::disk('local')->put('public/product', $file);
            $inputs['icon'] = $dataUpload;
        }

        $this->productRepository->create($inputs);

        return redirect()->route('admin.product.index');
    }

    public function edit($id)
    {
        $model = $this->productRepository->firstByKey($id);

        return view('admin.product.edit', compact('model'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $model = $this->productRepository->firstByKey($id);
        if(!$model) {
            throw new Exception("Cannot find Product");
        }

        $inputs = $request->only([
            'name',
            'price',
            'product_type',
            'version',
            'key_version',
            'description',
            'number_of_change',
            'discount',
            'type',
            'status',
            'input_price',
            'api'
        ]);

        $file = $request->file('icon');
        if($file) {
            $dataUpload = Storage::disk('local')->put('public/product', $file);
            $inputs['icon'] = $dataUpload;
        }

        $this->productRepository->update($model, $inputs);

        return redirect()->route('admin.product.index');
    }

    public function destroy($id)
    {
        $model = $this->productRepository->firstByKey($id);
        if(!$model) {
            throw new Exception("Cannot find Product");
        }

        $this->productRepository->delete($model);

        return redirect()->route('admin.product.index');
    }
}
