<?php

namespace App\Repositories\Production;


use App\Models\Registered;
use App\Repositories\CustomerRepositoryInterface;
use Carbon\Carbon;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function __construct(Registered $model)
    {
        parent::__construct($model);
    }

    public function buildQueryByFilter($query, $filter)
    {
        if(array_key_exists('query', $filter)) {
            $searchWork = $filter['query'];
            if(!empty($searchWork)) {
                $query = $query->where(function($q) use ($searchWork) {
                    $q->where('customer_name', 'LIKE', "%$searchWork%")
                        ->orWhere('customer_email', 'LIKE', "%$searchWork%")
                        ->orWhere('license_serial', 'LIKE', "%$searchWork%")
                        ->orWhere('license_original', 'LIKE', "%$searchWork%")
                        ->orWhere('hardware_id', 'LIKE', "%$searchWork%")
                        ->orWhere('customer_phone', 'LIKE', "%$searchWork%")
                        ->orWhere('customer_address', 'LIKE', "%$searchWork%")
                        ->orWhere('license_activation_date', 'LIKE', "%$searchWork%")
                        ->orWhere('last_runing_date', 'LIKE', "%$searchWork%")
                        ->orWhere('license_expire_date', 'LIKE', "%$searchWork%");
                });

            }

            unset($filter['query']);
        }
        if(array_key_exists('product_type', $filter)) {
            $searchWork = $filter['product_type'];
            if(!empty($searchWork)) {
                $query = $query->where('product_type', "$searchWork");
            }

            unset($filter['product_type']);
        }

        if(array_key_exists('khoamem', $filter)) {
            $searchWork = $filter['khoamem'];
            if(!empty($searchWork)) {
                $query = $query->whereHas('product', function ($q) {
                    $q->where('type', 0);
                });
//                $query = $query->whereNotIn('hardware_id', ["KHOACUNG", "KHOAHOC"]);
            }

            unset($filter['khoamem']);
        }

        if(array_key_exists('license_status', $filter)) {
            $searchWork = $filter['license_status'];
            if(!is_blank($searchWork)) {
                $query = $query->whereHas('license', function ($q) use ($searchWork) {
                    return $q->where('status', $searchWork);
                });
            }

            unset($filter['license_status']);
        }



        if(array_key_exists('date', $filter)) {
            $searchWork = $filter['date'];
            if(!empty($searchWork)) {
                $dateRange = explode('-',$searchWork);

                $query = $query->whereBetween('created_at', [
                    Carbon::parse($dateRange[0])->format('Y-m-d 00:00:00'),
                    Carbon::parse($dateRange[1])->format('Y-m-d 23:59:59')
                ]);
            }

            unset($filter['date']);
        }

        if(array_key_exists('status_sell', $filter)) {
            $searchWork = $filter['status_sell'];
            if(!empty($searchWork)) {
                $query = $query->where('status_sell', $searchWork);
            }

            unset($filter['status_sell']);
        }

        if(array_key_exists('customer_cty', $filter)) {
            $searchWork = $filter['customer_cty'];
            if(!empty($searchWork)) {
                $query = $query->where('customer_cty', $searchWork);
            }

            unset($filter['customer_cty']);
        }

        if(array_key_exists('hardware_id', $filter)) {
            $searchWork = $filter['hardware_id'];
            if(!empty($searchWork)) {
                $query = $query->where('hardware_id', $searchWork);
            }

            unset($filter['hardware_id']);
        }

        if(array_key_exists('expired_day', $filter)) {
            $searchWork = $filter['expired_day'];
            if(!empty($searchWork)) {
                $query = $query->where('license_expire_date', $searchWork);
            }

            unset($filter['expired_day']);
        }

        if(array_key_exists('before_expired_day', $filter)) {
            $searchWork = $filter['before_expired_day'];
            if(!empty($searchWork)) {
                $query = $query->whereBetween('license_expire_date', [Carbon::now()->format('Y-m-d'), $searchWork]);
            }

            unset($filter['before_expired_day']);
        }

        if(array_key_exists('user_support_id', $filter)) {
            $searchWork = $filter['user_support_id'];
            if(!empty($searchWork)) {
                $query = $query->where('user_support_id', $searchWork);
            }

            unset($filter['user_support_id']);
        }

        if(array_key_exists('last_runing_date', $filter)) {
            $searchWork = $filter['last_runing_date'];
            if(!empty($searchWork)) {
                $query = $query->where('last_runing_date', $searchWork);
            }

            unset($filter['last_runing_date']);
        }

        if(array_key_exists('license_activation_date', $filter)) {
            $searchWork = $filter['license_activation_date'];
            if(!empty($searchWork)) {
                $query = $query->where('license_activation_date', $searchWork);
            }

            unset($filter['license_activation_date']);
        }

        $query = $query->with(['product', 'license', 'user', 'license.user']);

        return parent::buildQueryByFilter($query, $filter); // TODO: Change the autogenerated stub
    }
}
