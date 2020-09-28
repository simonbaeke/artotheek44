<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/11/18
 * Time: 23:10
 */

namespace App\Repositories;


use App\Http\Filter\SubscriptionFilter;
use App\Http\Filters\QueryFilter;
use App\Subscription;

interface SubscriptionRepositoryInterface
{
    public function index(SubscriptionFilter $filter);

    public function store(array $attributes);

    public function show(Subscription $subscription);

    public function update(Subscription $subscription, array $attributes);

    public function renew(Subscription $subscription);

    public function confirm(Subscription $subscription);
}
