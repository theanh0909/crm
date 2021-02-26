<?php

namespace App\Repositories\Production;

use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function buildQueryByFilter($query, $filter)
    {
        if(array_key_exists('query',$filter)) {
            if(!empty($filter['query'])) {
                $keywork = $filter['query'];
                $query = $query->where('name', 'LIKE', "%{$keywork}%");
            }
            unset($filter['query']);
        }
        return parent::buildQueryByFilter($query, $filter);
    }

}
