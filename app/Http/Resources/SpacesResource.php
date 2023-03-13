<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpacesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'desc'=>$this->desc,
            'cat'=>$this->cat,
            'price'=>$this->price,
            'height'=>$this->height,
            'width'=>$this->width,
            'location'=>$this->location,
            'user'=>new UsersResource($this->user),
            'category'=> CategoriesResource::collection($this->categories),
            'reservations'=>ReservationsResource::collection($this->reservations)
        ];
    }
}
