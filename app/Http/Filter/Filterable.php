<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 7/10/18
 * Time: 16:20
 */

namespace App\Http\Filter;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * @param Builder $builder
     * @param QueryFilter $filter
     */
    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        $filter->apply($builder);
    }
}
