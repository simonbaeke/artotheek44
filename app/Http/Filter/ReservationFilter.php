<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/11/18
 * Time: 23:04
 */

namespace App\Http\Filter;


use App\Http\Filter\QueryFilter;
use http\Env\Request;
use Illuminate\Database\Eloquent\Builder;

class ReservationFilter extends QueryFilter
{

    public function search(string $search)
    {
        $this->builder->where('firstname', 'LIKE', '%' . $search . '%')
            ->orWhere('lastname', 'LIKE', '%' . $search . '%');
    }

    public function artwork(string $artwork_id)
    {
        $this->builder->where('artwork_id', $artwork_id);
    }

    public function active(string $activestate){
        if ($activestate == "indeterminate"){
            return $this->builder;
        }

        $flag = $activestate == "true";

        return $this->builder->active($flag);
    }

    public function expired(string $expiredstate){
        if($expiredstate == "indeterminate"){
            return $this->builder;
        }
        return $this->builder->expired($expiredstate == "true");
    }
}
