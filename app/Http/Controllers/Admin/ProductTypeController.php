<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use App\Http\Requests\Admin\ProductType\StoreRequest;
use App\Http\Requests\Admin\ProductType\UpdateRequest;
use Mockery\Exception;

class ProductTypeController extends Controller
{
    public function index()
    {
        $models = ProductType::all();
        return view('admin.product_type.index', compact(
            'models'
        ));
    }

    public function create()
    {
        return view('admin.product_type.create');
    }

    public function store(StoreRequest $request)
    {
        try {
            $inputs = $request->only([
                'name',
            ]);
            ProductType::create($inputs);

            return redirect()->route('admin.product-type.index');
        } catch (Exception $e) {
            throw new Exception($e);
        }

    }


    public function edit($id)
    {
        $model = ProductType::find($id);
        if(!$model) {
            return redirect()->route('admin.product-type.index');
        }

        return view('admin.product_type.edit', compact(
            'model'
        ));
    }

    public function update(UpdateRequest $request, $id)
    {
        $model = ProductType::find($id);
        if(!$model) {
            return redirect()->route('admin.product-type.index');
        }

        $inputs = $request->only([
            'name',
        ]);

        try {
            $model->update($inputs);

            return redirect()->route('admin.product-type.index');
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function destroy($id)
    {
        $model = ProductType::find($id);
        if(!$model) {
            return redirect()->route('admin.product-type.index');
        }

        $model->delete();
        return redirect()->route('admin.product-type.index');
    }
}
