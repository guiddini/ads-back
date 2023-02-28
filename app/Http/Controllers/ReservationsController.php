<?php

namespace App\Http\Controllers;

use App\Events\Reserved;
use App\Http\Resources\ReservationsResource;
use App\Models\Reservation;
use App\Models\Space;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Space  $space
     * @param  \Illuminate\Http\Request  $request
     * @return ReservationsResource
     */
    public function store(Request $request, Space $space)
    {
        $reservation = $space->reservations()->create([
            'user_id'=>$request->user()->id,
            'reservable_id'=>$space->id,
            'start_date'=>Carbon::parse($request->start),
            'end_date'=>Carbon::parse($request->end)
        ]);

        event(new Reserved(Auth::user()->fname));

        return new ReservationsResource($reservation);
    }

    /**
     * Display the specified resource.
     *
     * @param  Reservation  $reservation
     * @return ReservationsResource
     */
    public function show(Reservation $reservation)
    {
        return new ReservationsResource($reservation->load('user', 'reservable'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Reservation  $reservation
     * @return Response
     */
    public function destroy(Reservation  $reservation)
    {
        $reservation->delete();

        return response(null, 204);
    }
}
