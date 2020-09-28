<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 20/11/18
 * Time: 17:18
 */

namespace App\Services;


use App\Artist;

class ArtistService
{
    protected $artist;

    public function __construct(Artist $artist)
    {
        $this->artist = $artist;
    }

    public function index()
    {
        return $this->artist->all();
    }

    public function store(array $attributes){
        return Artist::create($attributes);
    }
}
