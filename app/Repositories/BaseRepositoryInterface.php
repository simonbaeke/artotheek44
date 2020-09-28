<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/11/18
 * Time: 23:11
 */

namespace App\Repositories;


interface BaseRepositoryInterface
{
    public function index($iets);
    public function store(array $attributes);
    public function show(Model $model);
    public function update(array $attributes);
}
