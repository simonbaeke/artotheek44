<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/11/18
 * Time: 23:36
 */

namespace App\Repositories;


use App\Rent;

interface RentRepositoryInterface
{
    public function index(QueryFilter $filter);

    public function store(array $attributes);

    public function show(Rent $rent);

    public function update(Rent $rent, array $attributes);
}
