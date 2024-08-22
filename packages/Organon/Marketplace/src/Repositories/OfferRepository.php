<?php

namespace Organon\Marketplace\Repositories;

use App\Notifications\OfferCreated;
use Illuminate\Support\Facades\Notification;
use Organon\Marketplace\Models\Offer;
use Webkul\Core\Eloquent\Repository;
use Webkul\Customer\Models\Customer;

class OfferRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Offer::class;
    }


    public function createOffer(array $data)
    {
        /** @var Offer */
        $model = $this->create($data);
        if(isset($data['image']))
            $model->setImage('image');

		Notification::send(Customer::all(), new OfferCreated());
    }

    public function updateOffer(Offer $model, array $data)
    {
        $model->update($data);
        if(isset($data['image'])){
            if(!isset($data['image']['image']))
                $model->setImage('image');
        }else
            $model->clearImage();
    }
}