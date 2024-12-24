<?php

namespace Organon\Wadili\Models;

use Organon\Marketplace\Models\Seller;
use Webkul\Core\Models\Address as ModelsAddress;

class Address
{
    public function __construct(
        private String $name,
        private String $lng,
        private String $lat,
        private String $street,
        private String $building,
        private String $floor,
        private String $details,
        private String $phone,
        private String $area,
    ) {}

    public static function fromAddress(ModelsAddress $address)
    {
        return new self(
            $address->name,
            $address->lng,
            $address->lat,
            $address->street,
            $address->building,
            $address->floor,
            $address->address_details,
            $address->phone,
            $address->area->name
        );
    }

    public static function fromSeller(Seller $seller)
    {
        return new self(
            $seller->name,
            $seller->lng,
            $seller->lat,
            $seller->street,
            $seller->building,
            $seller->floor,
            $seller->address,
            $seller->phone,
            $seller->area->name
        );
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'street' => $this->street,
            'building' => $this->building,
            'floor' => $this->floor,
            'otherDetails' => $this->details,
            'location' => [
                'longitude' => $this->lng,
                'latitude' => $this->lat,
            ],
            'mobileNumber' => $this->phone,
            'area' => $this->area
        ];
    }
}
