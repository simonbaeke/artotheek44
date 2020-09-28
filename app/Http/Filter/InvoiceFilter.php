<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/10/2019
 * Time: 19:32
 */

namespace App\Http\Filter;

use App\Http\Filter\QueryFilter;
use http\Env\Request;
use Illuminate\Database\Eloquent\Builder;
use phpDocumentor\Reflection\Types\Boolean;

class InvoiceFilter extends QueryFilter
{
    public function confirmed(String $flag){
        $this->builder->where('confirmed',$flag ==='true');
    }

    public function user(String $user){
        $this->builder->where('user_id',$user);
    }

}
