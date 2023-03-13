<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
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
            'label'=>$this->label,
            'parent_id'=>$this->parent_id,
            'parent'=>new CategoriesResource($this->whenLoaded('parent')),
            'children'=>SubCategoriesResource::collection($this->children)
        ];
    }
}
