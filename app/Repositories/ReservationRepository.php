<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/11/18
 * Time: 21:54
 */

namespace App\Repositories;
use App\Reservation;

class ReservationRepository
{
    protected $reservation;
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function index(){

    }

}
