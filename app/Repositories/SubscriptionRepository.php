<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/11/18
 * Time: 23:12
 */

namespace App\Repositories;


use App\Confirmed;
use App\Expire;
use App\Http\Filter\SubscriptionFilter;
use App\Http\Resources\SubscriptionResource;
use App\Subscription;
use Carbon\Carbon;

class SubscriptionRepository extends BaseRepository implements SubscriptionRepositoryInterface
{


    public function __construct(Subscription $model)
    {
        parent::__construct($model);
    }

    public function index(SubscriptionFilter $filter)
    {
        return SubscriptionResource::collection($this->model::filter($filter)->with('rents')->with('reservations')->get());
    }

    public function store(array $attributes)
    {
        return $this->model::create($attributes);
    }

    public function show(Subscription $subscription)
    {
        return $subscription;
    }

    public function update(Subscription $subscription, array $attributes)
    {
        // TODO: Implement update() method. ah
        $subscription->active = $attributes['active'];
        $subscription->save();

        return Subscription::findOrFail($subscription->id);
    }

    public function renew(Subscription $subscription)
    {
        $this->model->save(Expire::create([
            'date' => Carbon::parse($subscription->expire)->addYear(1)
        ]));
    }

    public function confirm(Subscription $subscription)
    {
        $this->model->save(Confirmed::create());
    }
}
