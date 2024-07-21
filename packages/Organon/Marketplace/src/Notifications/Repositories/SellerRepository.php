<?php

namespace Organon\Marketplace\Notifications\Repositories;

use Organon\Marketplace\Enums\SellerStatusEnum;
use Organon\Marketplace\Models\Seller;
use Webkul\Core\Eloquent\Repository;

class SellerRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Organon\Marketplace\Contracts\Seller';
    }



    public function activate($id)
    {
        $this->find($id)->setStatus(SellerStatusEnum::ACTIVE);
    }

    public function deactivate($id)
    {
        $this->find($id)->setStatus(SellerStatusEnum::DEACTIVATED);
    }

    public function findBySlug(string $slug): Seller
    {
        return Seller::bySlug($slug);
    }

    public function getAll()
    {
        $searchTerm = request()->input('query');
        $query = $this->query();
        $query = $query->isActive();
        $query = $query->where(function($query) use ($searchTerm){
            $query = $query->where('name', 'LIKE', "%$searchTerm%");
            $query = $query->orWhereHas('area', function($query) use ($searchTerm){
                return $query->where('name', 'LIKE', "%$searchTerm%");
            });
            $query = $query->orWhereHas('sellerCategory', function($query) use ($searchTerm){
                $query = $query->where('name', 'LIKE', "%$searchTerm%");
                $query = $query->orWhereHas('parent', function($query) use ($searchTerm){
                    return $query->where('name', 'LIKE', "%$searchTerm%");
                });
            });
        });
        return $query->get();
    }
}
