<?php

namespace App\Http\Resources\API\Notifications;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationsResource extends JsonResource
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
            'order_id'          => $this->order_id,
            'notification_type' => $this->notification_type,
            'message'           => $this->get_message,
            'created_at'        => $this->created_at->diffForHumans(),
        ];
    }
}
