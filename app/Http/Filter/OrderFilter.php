<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 11/02/19
 * Time: 15:35
 */

namespace App\Http\Filter;

use App\Http\Filter\QueryFilter;

class OrderFilter extends QueryFilter
{
    public function user(string $user_id)
    {
        $this->builder->whereUser_id($user_id);
    }

    public function pending(string $pending)
    {
        if ($pending == 'true') {
            $this->builder->doesntHave('invoice');
        } else {
            $this->builder->has('invoice');
        }
    }

    public function invoice(string $invoiceid)
    {
        $this->builder->whereInvoice_id($invoiceid);
    }
}
