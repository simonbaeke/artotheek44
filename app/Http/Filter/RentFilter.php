<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 29/11/18
 * Time: 20:42
 */

namespace App\Http\Filter;

use App\Http\Filter\QueryFilter;
use http\Env\Request;
use Illuminate\Database\Eloquent\Builder;

class RentFilter extends QueryFilter
{

    public function artwork(string $artwork_id)
    {
        $this->builder->where('artwork_id', strtolower($artwork_id));
    }

    public function subscription(string $id){
        $this->builder->where('subscription_id', strtolower($id));

    }

    public function returned(bool $flag){
        if ($flag){
            $this->builder->where('returned_at','=',null);

        }
        else{
            $this->builder->where('returned_at','!=',null);

        }
    }

    public function search(string $searchstring)
    {
        $searchby = 'all';
        if ($this->request->has('searchby')) {
            $searchby = $this->request->input('searchby');
        }



        switch ($searchby) {
            case "all":
                $this->builder->whereHas('artwork.artist', function (Builder $q) use ($searchstring) {
                    $q->where('firstname', 'LIKE', '%' . $searchstring . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $searchstring . '%');
                })->orWhereHas('subscription.user', function (Builder $q) use ($searchstring) {
                    $q->where('firstname', 'LIKE', '%' . $searchstring . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $searchstring . '%');
                })->orWhereHas('artwork', function (Builder $q) use ($searchstring) {
                    $q->where('name', 'LIKE', '%' . $searchstring . '%');
                });
                break;
            case "artist":
                $this->builder->whereHas('artwork.artist', function (Builder $q) use ($searchstring) {
                    $q->where('firstname', 'LIKE', '%' . $searchstring . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $searchstring . '%');
                });
                break;
            case "user" :
                $this->builder->whereHas('subscription.user', function (Builder $q) use ($searchstring) {
                    $q->where('firstname', 'LIKE', '%' . $searchstring . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $searchstring . '%');
                });
                break;
            case "artwork":
                $this->builder->whereHas('artwork', function (Builder $q) use ($searchstring) {
                    $q->where('name', 'LIKE', '%' . $searchstring . '%');
                });
                break;
        }
    }

}
