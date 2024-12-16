<?php

namespace App\Http\Resources\API\Cars;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Colors\ColorsResource;
use App\Http\Resources\API\CarCountryFactory\CarCountryFactoryResource;
use App\Http\Resources\API\CarMake\CarMakeChildrenResource;
use App\Http\Resources\API\CarMake\CarMakeResource;

class CarsResource extends JsonResource
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
            'id'                    => $this->id,
            'color'                 => (is_null($this->color)) ? [] : new ColorsResource($this->color),
            'car_country_factory'   => (is_null($this->carCountryFactory)) ? [] : new CarCountryFactoryResource($this->carCountryFactory),
            "vin"                   => $this->vin ?? '',
            "vds"                   => (is_null($this->vdsData)) ? [] : new CarMakeResource($this->vdsData),
            // "region"            => $this->region,
            // "country"           => $this->country,
            "manufacturer"          => (is_null($this->manufacturerData)) ? [] : new CarMakeChildrenResource($this->manufacturerData),
            "modelYear"             => $this->modelYear,
            // "data"              => $this->data,
        ];
    }
}
