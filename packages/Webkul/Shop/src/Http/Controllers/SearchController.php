<?php

namespace Webkul\Shop\Http\Controllers;

use Organon\Marketplace\Notifications\Repositories\SellerRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Product\Repositories\SearchRepository;

class SearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ProductRepository $productRepository,
        protected SearchRepository $searchRepository,
        protected SellerRepository $sellerRepository
    )
    {
    }

    /**
     * Index to handle the view loaded with the search results
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $results = [];
        
        request()->validate([
            'query' => 'required',
        ]);

        request()->query->add([
            'name'  => request('term'),
            'sort'  => 'created_at',
            'order' => 'desc',
        ]);

        $results = $this->productRepository->getAll();
        $resultsSellers = $this->sellerRepository->getAll();

        return view('shop::search.index')->with('results', $results->count() ? $results : null)->with('sellers', $resultsSellers);
    }

    /**
     * Upload image for product search with machine learning.
     *
     * @return string
     */
    public function upload()
    {
        return $this->searchRepository->uploadSearchImage(request()->all());
    }
}
