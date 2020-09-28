<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 12/03/2019
 * Time: 19:27
 */

namespace App\Http\Filter;


class UserArtworkFilter extends QueryFilter
{
    public function user(string $user)
    {
        $this->builder->where('user_id', $user);
    }

    public function artwork(string $artwork)
    {
        $this->builder - where('artwork_id', $artwork);
    }

}
