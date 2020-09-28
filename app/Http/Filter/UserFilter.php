<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 16/11/18
 * Time: 10:51
 */

namespace App\Http\Filter;


use App\Http\Filter\QueryFilter;
use http\Env\Request;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends QueryFilter
{
    public function search(string $search)
    {
        $this->builder->where('firstname', 'LIKE', '%' . $search . '%')
            ->orWhere('lastname', 'LIKE', '%' . $search . '%');
    }

    public function user($id)
    {
        $this->builder->where('id', strtolower($id));

    }

    public function role(string $role){
        $this->builder->role($role);
    }
}
