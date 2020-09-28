<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 14/03/2019
 * Time: 14:59
 */

namespace App\Interfaces;


interface Renewable
{
    public function renewDate();

    public function canBeRenewed();

}
