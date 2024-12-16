<?php

namespace App\Http\Resources\API\Provider;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\CarCountryFactory\CarCountryFactoryResource;
use App\Http\Resources\API\Categories\CategoriesResource;
use App\Http\Resources\API\HowToKnowUs\HowToKnowUsResource;
use App\Http\Resources\API\Areas\AreasResource;


class ProviderResource extends JsonResource
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
            // 'first_name'                        => $this->first_name,
            'id'                                => $this->id,
            'provider_name'                     => $this->provider_name,
            'email'                             => $this->email,
            'phone'                             => $this->phone,
            'phone_verified'                    => (is_null($this->phone_verified_at)) ? false:true,
            'how_to_know_us'                    => $this->how_to_know_us,
            'how_to_know_us'                    => new HowToKnowUsResource($this->KnowUs),
            'commercial_registration_number'    => $this->commercial_registration_number,
            'tax_number'                        => $this->tax_number,
            'region'                            => (is_null($this->getRegion)) ? [] : new AreasResource($this->getRegion),
            'city'                              => (is_null($this->getCity)) ? [] : new AreasResource($this->getCity),
            'lat'                               => $this->lat,
            'lng'                               => $this->lng,
            'terms'                             => $this->terms ?? '',
            'completed_data'                    => (is_null($this->terms)) ? false : true,
            "avatar"                            => display_image_by_model($this,"avatar"),
            "rates"                             => $this->rates,
            "rates_count"                       => $this->rates()->count(),
            "categories"                        => CategoriesResource::collection($this->categories),
            "carCountryFactories"               => CarCountryFactoryResource::collection($this->carCountryFactories),
            "admin_approved"                    => ($this->admin_approved == 1) ? true : false,
            // ==================================================== //
            "vat"                               => $this->vat ?? 0,
            "commission_price"                  => $this->commission_price ?? 0,
        ];
    }
}
