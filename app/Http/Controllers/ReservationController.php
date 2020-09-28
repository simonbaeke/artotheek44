<?php

namespace App\Http\Controllers;

use App\Http\Filter\ArtworkFilter;
use App\Http\Filter\ReservationFilter;
use App\Http\Requests\StoreReservation;
use App\Http\Requests\UpdateReservation;
use App\Http\Resources\ReservationResource;
use App\Reservation;
use App\Services\ReservationService;
use App\Subscription;
use App\User;
use Illuminate\Http\Request;
use Auth;

class ReservationController extends Controller
{
    private $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ReservationFilter $filter, Request $request)
    {
        return $this->reservationService->index($filter, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReservation $request)
    {
        try {
            return new ReservationResource($this->reservationService->store($request->all()));

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReservation $request, Reservation $reservation)
    {
        if ($reservation->isActive() && $request->has('active') && $request->input('active')==true){
            //Artwork available notification
        }

        return new ReservationResource($this->reservationService->update($reservation, $request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //delete expires

        //notify artwork available
    }
}
