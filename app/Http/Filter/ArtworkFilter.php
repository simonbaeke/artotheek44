<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/11/18
 * Time: 22:47
 */

namespace App\Http\Filter;

use Illuminate\Database\Eloquent\Builder;

class ArtworkFilter extends QueryFilter
{

    public function type(string $type)
    {
        $type = explode('-', $type);

        $this->builder->whereHas('type', function (Builder $q) use ($type) {
            $q->where('name', ($type));
        });
    }

    public function artist(string $artist)
    {
        $this->builder->where('artist_id', $artist);
    }

    public function sold(string $issold)
    {
        $this->builder->sold($issold == 'true');
    }

    public function status(string $status)
    {
        switch ($status) {
            case "beschikbaar":
                $this->builder->whereDoesntHave('rents', function ($query) {
                    $query->returned(false);
                })->whereDoesntHave('reservations', function ($query) {
                    $query->active(true);
                });
                break;

            case "ontleend":
                $this->builder->whereHas('rents', function ($query) {
                    $query->returned(false);
                });
                break;

            case "gereserveerd":
                $this->builder->whereHas('reservations', function ($query) {
                    $query->active(true);
                });
                break;
            default:

        }
    }

    /**
     * @param string $string
     */
    public function search(string $searchstring)
    {
        $searchby = 'all';
        if ($this->request->has('searchby')) {
            $searchby = $this->request->input('searchby');
        }

        switch ($searchby) {
            case "all";
                $this->builder->where('name', 'like', '%' . $searchstring . '%')
                    ->orWhereHas('artist', function (Builder $q) use ($searchstring) {
                        $q->where('firstname', 'LIKE', '%' . $searchstring . '%')
                            ->orWhere('lastname', 'LIKE', '%' . $searchstring . '%');
                    });
                break;
            case "object":
                $this->builder->where('name', 'like', '%' . $searchstring . '%');
                break;
            case "artist":
                $this->builder->whereHas('artist', function (Builder $q) use ($searchstring) {
                    $q->where('firstname', 'LIKE', '%' . $searchstring . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $searchstring . '%');
                });
                break;
        }
    }

}
