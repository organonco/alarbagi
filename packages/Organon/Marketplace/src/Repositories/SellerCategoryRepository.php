<?php

namespace Organon\Marketplace\Repositories;

use Organon\Marketplace\Models\SellerCategory;
use Webkul\Core\Eloquent\Repository;

class SellerCategoryRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return SellerCategory::class;
    }

    public function createSellerCategory($data)
    {
        /** @var SellerCategory */
        $model = SellerCategory::create($data);
        if(isset($data['banner']))
            $model->addBanner('banner');
        return $model;
    }

    public function updateSellerCategory(SellerCategory $model, array $data)
    {
        $model->update($data);
        if(isset($data['banner'])){
            if(!isset($data['banner']['image']))
                $model->addBanner('banner');
        }else
            $model->clearBanner();
    }
}