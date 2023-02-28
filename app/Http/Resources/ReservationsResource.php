<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationsResource extends JsonResource
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
            'start'=>$this->start_date,
            'end'=>$this->end_date,
            'user'=>new UsersResource($this->whenLoaded('user')),
            'space'=>new SpacesResource($this->whenLoaded('reservable'))
        ];
    }
}
