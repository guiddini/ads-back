<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return UsersResource::collection(
            User::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return UsersResource
     */
    public function show(User $user)
    {
        return new UsersResource($user->load('spaces', 'reservations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  User  $user
     * @return UsersResource
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return new UsersResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $user->tokens()->delete();
        $user->delete();

        return response(null, 204);
    }
}
