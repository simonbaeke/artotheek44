<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 14/03/2019
 * Time: 15:03
 */

namespace App\Interfaces;


interface Orderable
{
    public function getAmount();

    public function getUserId();

}
