<?php

namespace App\Providers;

use App\Confirmed;
use App\FreeRent;
use App\Observers\FreeRentObserver;
use App\Observers\PreferenceObserver;
use App\Observers\SubscriptionConfirmedObserver;
use App\Preference;
use Illuminate\Support\ServiceProvider;
use App\Artwork;
use App\BankTransfert;
use App\Expire;
use App\Observers\ArtworkObserver;
use App\Observers\BankTransfertObserver;
use App\Observers\ConfirmedObserver;
use App\Observers\ExpireObserver;
use App\Observers\OrderObserver;
use App\Observers\PayObserver;
use App\Observers\RentObserver;
use App\Observers\ReservationObserver;
use App\Observers\SubscriptionObserver;
use App\Observers\UserObserver;
use App\Observers\VoucherPayObserver;
use App\Pay;
use App\Rent;
use App\Order;
use App\Reservation;
use App\Subscription;
use App\VoucherPay;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        //


        Validator::extend('uniqueCombo', function ($attribute, $value, $parameters, $validator) {

            $query = DB::table($parameters[0])
                ->where($attribute, '=', $value)
                ->where($parameters[1], '=', request($parameters[1]));

            if (isset($parameters[2])) {
                $query = $query->where('id', '<>', $parameters[2]);
            }

            return ($query->count() <= 0);
        });


        Relation::morphMap([
            'Subscription' => 'App\Subscription',
            'Rent' => 'App\Rent',
            'Reservation' => 'App\Reservation',
            'Order' => 'App\Order',
            'Expire' => 'App\Expire',
            'Confirmed' => 'App\Confirmed',
            'Cash' => 'App\Cash',
            'BankTransfert' => 'App\BankTransfert',
            'VoucherPay' => 'App\VoucherPay',
            'Voucher' => 'App\Voucher'
        ]);

        Rent::observe(RentObserver::class);
        Subscription::observe(SubscriptionObserver::class);
        Order::observe(OrderObserver::class);
        Expire::observe(ExpireObserver::class);
        BankTransfert::observe(BankTransfertObserver::class);
        Pay::observe(PayObserver::class);
        VoucherPay::observe(VoucherPayObserver::class);
        Reservation::observe(ReservationObserver::class);
        Artwork::observe(ArtworkObserver::class);
        FreeRent::observe(FreeRentObserver::class);
        Confirmed::observe(SubscriptionConfirmedObserver::class);
        Preference::observe(PreferenceObserver::class);
    }
}
