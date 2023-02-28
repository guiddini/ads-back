<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            'fname'=>$this->fname,
            'lname'=>$this->lname,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'dob'=>$this->dob,
            'address'=>$this->address,
            'spaces'=>SpacesResource::collection($this->whenLoaded('spaces')),
            'reservations'=>ReservationsResource::collection($this->whenLoaded('reservations'))
        ];
    }
}
