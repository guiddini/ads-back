<?php

namespace App\Http\Controllers;


use App\Models\Space;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SpacesResource;
use App\Http\Requests\StoreSpaceRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SpacesController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return SpacesResource::collection(
            Space::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSpaceRequest $spaceRequest
     * @return SpacesResource
     */
    public function store(StoreSpaceRequest $spaceRequest)
    {
        $spaceRequest->validated($spaceRequest->all());

        $space = Space::create([
            'user_id'=>Auth::user()->id,
            'name'=>$spaceRequest->name,
            'desc'=>$spaceRequest->desc,
            'image'=>'image.jpg',
            'cat'=>$spaceRequest->cat,
            'price'=>$spaceRequest->price,
            'height'=>$spaceRequest->height,
            'width'=>$spaceRequest->width,
            'location'=>$spaceRequest->location
        ]);

        return new SpacesResource($space);
    }

    /**
     * Display the specified resource.
     *
     * @param  Space $space
     * @return SpacesResource
     */
    public function show(Space $space)
    {
        return new SpacesResource($space);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  Space  $space
     * @return SpacesResource
     */
    public function update(Request $request, Space $space)
    {
        $space->update($request->all());

        return new SpacesResource($space);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Space  $space
     * @return Response
     */
    public function destroy(Space $space)
    {
        $space->delete();

        return response(null, 204);
    }
}
