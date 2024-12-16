<?php

namespace App\Http\Resources\API\Orders\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Provider\ProviderResource;

class AnswerResource extends JsonResource
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
            "accept"            => $this->accept,
            "created_at"        => $this->created_at->diffForHumans(),
            "answer"            => $this->answer,
            "order_id"          => $this->order_id,
            "provider_id"       => new ProviderResource($this->provider),
        ];
    }
}
