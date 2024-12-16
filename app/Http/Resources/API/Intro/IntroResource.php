<?php

namespace App\Http\Resources\API\Intro;

use Illuminate\Http\Resources\Json\JsonResource;

class IntroResource extends JsonResource
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
            'image'             => display_image_by_model($this,'image'),
            'description'       => $this->description,
        ];
    }
}
