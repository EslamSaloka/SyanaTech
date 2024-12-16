<?php

namespace App\Http\Resources\API\CarCountryFactory;

use Illuminate\Http\Resources\Json\JsonResource;

class CarCountryFactoryResource extends JsonResource
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
            'id'                => $this->id,
            'name'              => $this->name,
            // 'image'             => display_image_by_model($this,'image'),
        ];
    }
}
