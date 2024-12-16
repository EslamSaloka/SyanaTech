<?php

namespace App\Http\Resources\API\CarMake;

use Illuminate\Http\Resources\Json\JsonResource;

class CarMakeResource extends JsonResource
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
            'id'           => $this->id,
            'name'         => $this->name ?? '',
            "has_child"    => ($this->children()->count() > 0) ? true : false
        ];
    }
}
