<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 14/11/18
 * Time: 14:16
 */

namespace App\Http\Filter;

use App\Http\Filter\QueryFilter;

class SubscriptionFilter extends QueryFilter
{
    public function user(string $user_id)
    {
        $this->builder->where('user_id', strtolower($user_id));
    }

    public function available(string $available)
    {
        $this->builder->available();
    }

    public function id(string $id){
        $this->builder->where('id', strtolower($id));

    }

}
