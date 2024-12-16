<?php

namespace App\Http\Resources\API\Orders;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Orders\Order\AnswerResource;
use App\Http\Resources\API\Orders\Order\ImageResource;
use App\Http\Resources\API\Orders\Order\ItemResource;
use App\Http\Resources\API\Categories\CategoriesResource;
use App\Http\Resources\API\Cars\CarsResource;
use App\Http\Resources\API\Customer\CustomerResource;
use App\Http\Resources\API\Provider\ProviderResource;
use App\Http\Resources\API\Areas\AreasResource;
use App\Http\Resources\API\CarCountryFactory\CarCountryFactoryResource;
use App\Http\Resources\API\Refusals\RefusalsResource;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $return = [
            'id'              => $this->id,
            "customer_rate"   => ($this->rate == 1) ? true : false,
            "created_at"      => $this->created_at->diffForHumans(),
            "order_status"    => $this->order_status ?? "new",
            "order_place"     => $this->order_place,
            "location"        => [
                "address_name"    => $this->address_name,
                "location_name"   => $this->location_name,
                "lat"             => $this->lat,
                "lng"             => $this->lng,
                "region"          => (is_null($this->region)) ? [] : new AreasResource($this->region),
                "city"            => (is_null($this->city)) ? [] : new AreasResource($this->city),
            ],
            // "car_country_factory"  => (is_null($this->carCountryFactory)) ? [] : new CarCountryFactoryResource($this->carCountryFactory),
            "description"     => $this->description ?? '',
            "prices"          => [
                "sub_total"        => $this->sub_total ?? 0,
                "vat"              => $this->vat ?? 0,
                "commission_price" => $this->commission_price ?? 0,
                "total"            => $this->total ?? 0,
            ],
            "dues"                      => ($this->dues == 1) ? false : true,
            // 'customer_name'             => $this->customer_name,
            "customer"                  => new CustomerResource($this->customer),
            "provider"                  => (is_null($this->provider)) ? [] : new ProviderResource($this->provider),
            // "car"                       => new CarsResource($this->car),
            "car"                       => $this->car_information ?? [],
            "category"                  => new CategoriesResource($this->category),
            "invoice_items"             => ItemResource::collection($this->items),
            "invoice_items_message"     => ($this->items()->count() > 0) ? '' : __("Invoice doesn't have been created until now"),
            "images"                    => ImageResource::collection($this->images),
        ];
        if($this->order_status == "process") {
            $return['process_at'] = \Carbon\Carbon::parse($this->process_at)->diffForHumans();
        }
        if($this->order_status == "done") {
            $return['completed_at'] = (is_null($this->completed_at)) ? '':\Carbon\Carbon::parse($this->completed_at)->diffForHumans();
        }
        if(\Auth::check()) {
            if(\Auth::user()->user_type == "customer") {
                $return["answers"]['accept_answer'] = ($this->answers()->where('accept',1)->count() == 0) ? false : true;
                $return["answers"]['answer_count'] = $this->answers()->count();
                if($this->answers()->where('accept',1)->count() > 0) {
                    $return["answers"]['accept'] = new AnswerResource($this->answers()->where('accept',1)->first());
                    $return["answers"]['lists'] = [];
                } else {
                    $return["answers"]['accept'] = [];
                    $return["answers"]['lists'] = AnswerResource::collection($this->answers);
                }

            }
        }
        if(\Auth::check()) {
            if(\Auth::user()->user_type == "provider") {
                $return["answers"]['make_answer'] = ($this->answers()->where('provider_id',\Auth::user()->id)->count() == 0) ? false : true;
                $return["answers"]['answer'] = ($this->answers()->where('provider_id',\Auth::user()->id)->count() == 0) ? [] : new AnswerResource($this->answers()->where('provider_id',\Auth::user()->id)->first());
            }
        }


        if($this->order_status == "cancel") {
            $return["cancel_by"]         = $this->close_by;
            $return["cancel_message"]    = (is_null($this->refusals)) ? [] : new RefusalsResource($this->refusals);
            $return["cancel_at"]         = (is_null($this->cancel_at)) ? '' : \Carbon\Carbon::parse($this->cancel_at)->diffForHumans();
        }
        return $return;
    }
}
