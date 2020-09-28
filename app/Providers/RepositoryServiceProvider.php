<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/11/18
 * Time: 22:43
 */

namespace App\Providers;


use App\Repositories\ArtworkRepositoryInterface;
use App\Repositories\ArtworkRespository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\SubscriptionRepositoryInterface;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
/*        $this->app->bind(
            ArtworkRepositoryInterface::class,
            ArtworkRespository::class
        );*/
/*        $this->app->bind(
            SubscriptionRepositoryInterface::class,
            SubscriptionRepository::class
        );*/


    }
}
