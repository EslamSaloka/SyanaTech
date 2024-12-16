<?php

namespace App\Http\Resources\API\Banks;

use Illuminate\Http\Resources\Json\JsonResource;

class BanksResource extends JsonResource
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
            'bank_name'         => $this->bank_name ?? '',
            'account_name'      => $this->account_name ?? '',
            'account_number'    => $this->account_number,
            'iban'              => $this->iban,
            'image'             => display_image_by_model($this,'image'),
        ];
    }
}
