<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginsResource extends JsonResource
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
            'ip'=>$this->ip,
            'country'=>$this->country,
            'country_code'=>$this->country_code,
            'region'=>$this->region,
            'region_code'=>$this->region_code,
            'city'=>$this->city,
            'zip'=>$this->zip,
            'lat'=>$this->lat,
            'long'=>$this->long,
            'login_date_time'=>$this->login_date_time,
            'user'=>new UsersResource($this->whenLoaded('user'))
        ];
    }
}
