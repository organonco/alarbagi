<?php

namespace Webkul\Shop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'address_type'    => $this->address_type,
            'customer_id'     => $this->customer_id,
            'cart_id'         => $this->cart_id,
            'order_id'        => $this->order_id,
            'name'      => $this->name,
            'phone'       => $this->phone,
            'area'          => $this->area?->name,
            'address_details'    => $this->address_details,
            'default_address' => $this->default_address,
        ];
    }
}
