<?php

namespace App\Repositories\Production;


use App\Models\Permission;
use App\Repositories\PermissionRepositoryInterface;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function buildQueryByFilter($query, $filter)
    {
        if(array_key_exists('query',$filter)) {
            if(!empty($filter['query'])) {
                $keywork = $filter['query'];
                $query = $query->where('name', 'LIKE', "%{$keywork}%")
                    ->orWhere('display_name', 'LIKE', "%{$keywork}%");
            }
            unset($filter['query']);
        }
        return parent::buildQueryByFilter($query, $filter); // TODO: Change the autogenerated stub
    }

}