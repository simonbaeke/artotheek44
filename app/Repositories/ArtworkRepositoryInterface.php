<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/11/18
 * Time: 22:45
 */

namespace App\Repositories;


use App\Artwork;
use App\Http\Filter\ArtworkFilter;
use App\Http\Filters\QueryFilter;
use App\Subscription;
use Illuminate\Database\Eloquent\Model;

interface ArtworkRepositoryInterface
{
    public function index(ArtworkFilter $filter);

    public function store(array $attributes);

    public function show(Artwork $artwork);

    public function update(Artwork $artwork, array $attributes);

}
