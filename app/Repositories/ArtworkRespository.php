<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/11/18
 * Time: 21:54
 */

namespace App\Repositories;


use App\Artwork;
use App\Http\Filter\ArtworkFilter;
use App\Http\Filters\QueryFilter;
use App\Subscription;
use Illuminate\Database\Eloquent\Model;

class ArtworkRespository extends BaseRepository implements ArtworkRepositoryInterface
{
    public function __construct(Artwork $model)
    {
        parent::__construct($model);
    }


    public function index(ArtworkFilter $filter)
    {
        return $this->model::filter($filter)->all();
    }

    public function store(array $attributes)
    {
        return $this->model::create($attributes);
    }

    public function show(Artwork $artwork)
    {
        return $artwork;
    }

    public function update(Artwork $artwork, array $attributes)
    {
        // TODO: Implement update() method.
    }
}
