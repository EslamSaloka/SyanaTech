<?php

namespace App\Http\Resources\API\Customer;

use App\Http\Resources\API\Areas\AreasResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\HowToKnowUs\HowToKnowUsResource;

class CustomerResource extends JsonResource
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
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'phone_verified'    => (is_null($this->phone_verified_at)) ? false:true,
            'how_to_know_us'    => new HowToKnowUsResource($this->KnowUs),
            "avatar"            => display_image_by_model($this,"avatar"),
            // ============================= //
            'region'            => (is_null($this->getRegion)) ? [] : new AreasResource($this->getRegion),
            'city'              => (is_null($this->getCity)) ? [] : new AreasResource($this->getCity),
            'lat'               => $this->lat ?? '',
            'lng'               => $this->lng ?? '',
        ];
    }
}
