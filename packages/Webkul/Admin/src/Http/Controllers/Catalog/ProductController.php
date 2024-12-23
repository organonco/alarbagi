<?php

namespace Webkul\Admin\Http\Controllers\Catalog;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Organon\Marketplace\Models\Admin;
use Organon\Marketplace\Models\Product;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Webkul\Admin\DataGrids\Catalog\ProductDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Http\Requests\InventoryRequest;
use Webkul\Admin\Http\Requests\MassDestroyRequest;
use Webkul\Admin\Http\Requests\MassUpdateRequest;
use Webkul\Admin\Http\Requests\ProductForm;
use Webkul\Admin\Http\Resources\AttributeResource;
use Webkul\Attribute\Repositories\AttributeFamilyRepository;
use Webkul\Core\Rules\Slug;
use Webkul\Inventory\Repositories\InventorySourceRepository;
use Webkul\Product\Helpers\ProductType;
use Webkul\Product\Repositories\ProductAttributeValueRepository;
use Webkul\Product\Repositories\ProductDownloadableLinkRepository;
use Webkul\Product\Repositories\ProductDownloadableSampleRepository;
use Webkul\Product\Repositories\ProductInventoryRepository;
use Webkul\Product\Repositories\ProductRepository;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    /*
    * Using const variable for status
    */
    const ACTIVE_STATUS = 1;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected AttributeFamilyRepository $attributeFamilyRepository,
        protected InventorySourceRepository $inventorySourceRepository,
        protected ProductRepository $productRepository,
        protected ProductAttributeValueRepository $productAttributeValueRepository,
        protected ProductDownloadableLinkRepository $productDownloadableLinkRepository,
        protected ProductDownloadableSampleRepository $productDownloadableSampleRepository,
        protected ProductInventoryRepository $productInventoryRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(ProductDataGrid::class, ['sellerId' => request()->seller_id])->toJson();
        }

        $families = $this->attributeFamilyRepository->all();

        return view('admin::catalog.products.index', compact('families'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $families = $this->attributeFamilyRepository->all();

        $configurableFamily = null;

        if ($familyId = request()->get('family')) {
            $configurableFamily = $this->attributeFamilyRepository->find($familyId);
        }

        return view('admin::catalog.products.create', compact('families', 'configurableFamily'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required',
            'type'                => 'required',
            'attribute_family_id' => 'required',
            'super_attributes'    => 'array|min:1',
            'super_attributes.*'  => 'array|min:1',
        ]);

        if (
            ProductType::hasVariants(request()->input('type'))
            && ! request()->has('super_attributes')
        ) {
            $configurableFamily = $this->attributeFamilyRepository
                ->find(request()->input('attribute_family_id'));

            return new JsonResponse([
                'data' => [
                    'attributes' => AttributeResource::collection($configurableFamily->configurable_attributes),
                ],
            ]);
        }

        Event::dispatch('catalog.product.create.before');

        $data = request()->only([
            'name',
            'type',
            'attribute_family_id',
            'super_attributes',
            'family',
        ]);

        /** @var Admin $admin */
        $admin = auth('admin')->user();
        if ($admin->isSeller()) {
            $data['seller_id'] = $admin->getSellerId();
        }

        $uuid = (string)Str::uuid();

        $data = array_merge($data, [
            'sku' => $uuid, 'url_key' => $uuid, 'manage_stock' => 0
        ]);

        $product = $this->productRepository->create($data);

        Event::dispatch('catalog.product.create.after', $product);

        session()->flash('success', trans('admin::app.catalog.products.create-success'));

        return new JsonResponse([
            'data' => [
                'redirect_url' => route('admin.catalog.products.edit', $product->id),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        /** @var Product $product */
        $product = $this->productRepository->withoutGlobalScope('seller_status')->findOrFail($id);

        /** @var Admin $admin */
        $admin = auth('admin')->user();
        if ($admin->isSeller() && $admin->getSellerId() != $product->getSellerId()) {
            abort(401, 'this action is unauthorized');
        }

        $inventorySources = $this->inventorySourceRepository->findWhere(['status' => self::ACTIVE_STATUS]);

        return view('admin::catalog.products.edit', compact('product', 'inventorySources'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductForm $request, $id)
    {
        Event::dispatch('catalog.product.update.before', $id);

        /** @var Product $product */
        $product = $this->productRepository->withoutGlobalScope('seller_status')->findOrFail($id);

        /** @var Admin $admin */
        $admin = auth('admin')->user();
        if ($admin->isSeller() && $admin->getSellerId() != $product->getSellerId()) {
            abort(401, 'this action is unauthorized');
        }

        

        $product = $this->productRepository->update($request->all(), $id);

        Event::dispatch('catalog.product.update.after', $product);

        session()->flash('success', trans('admin::app.catalog.products.update-success'));

        return redirect()->route('admin.catalog.products.index');
    }

    /**
     * @return JsonResponse
     */
    public function updateInventories(InventoryRequest $inventoryRequest, $id)
    {
        /** @var Product $product */
        $product = $this->productRepository->findOrFail($id);

        /** @var Admin $admin */
        $admin = auth('admin')->user();
        if ($admin->isSeller() && $admin->getSellerId() != $product->getSellerId()) {
            abort(401, 'this action is unauthorized');
        }

        Event::dispatch('catalog.product.update.before', $id);

        $this->productInventoryRepository->saveInventories(request()->all(), $product);

        Event::dispatch('catalog.product.update.after', $product);

        return response()->json([
            'message'      => __('admin::app.catalog.products.saved-inventory-message'),
            'updatedTotal' => $this->productInventoryRepository->where('product_id', $product->id)->sum('qty'),
        ]);
    }

    /**
     * Uploads downloadable file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadLink($id)
    {
        /** @var Product $product */
        $product = $this->productRepository->findOrFail($id);

        /** @var Admin $admin */
        $admin = auth('admin')->user();
        if ($admin->isSeller() && $admin->getSellerId() != $product->getSellerId()) {
            abort(401, 'this action is unauthorized');
        }

        return response()->json(
            $this->productDownloadableLinkRepository->upload(request()->all(), $id)
        );
    }

    /**
     * Copy a given Product.
     *
     * @return \Illuminate\Http\Response
     */
    public function copy(int $id)
    {
        /** @var Product $product */
        $product = $this->productRepository->findOrFail($id);

        /** @var Admin $admin */
        $admin = auth('admin')->user();
        if ($admin->isSeller() && $admin->getSellerId() != $product->getSellerId()) {
            abort(401, 'this action is unauthorized');
        }

        try {
            $product = $this->productRepository->copy($id);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            return redirect()->to(route('admin.catalog.products.index'));
        }

        session()->flash('success', trans('admin::app.catalog.products.product-copied'));

        return redirect()->route('admin.catalog.products.edit', $product->id);
    }

    /**
     * Uploads downloadable sample file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadSample($id)
    {
        /** @var Product $product */
        $product = $this->productRepository->findOrFail($id);

        /** @var Admin $admin */
        $admin = auth('admin')->user();
        if ($admin->isSeller() && $admin->getSellerId() != $product->getSellerId()) {
            abort(401, 'this action is unauthorized');
        }

        return response()->json(
            $this->productDownloadableSampleRepository->upload(request()->all(), $id)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id): JsonResponse
    {
        /** @var Product $product */
        $product = $this->productRepository->findOrFail($id);

        /** @var Admin $admin */
        $admin = auth('admin')->user();
        if ($admin->isSeller() && $admin->getSellerId() != $product->getSellerId()) {
            abort(401, 'this action is unauthorized');
        }

        try {
            Event::dispatch('catalog.product.delete.before', $id);

            $this->productRepository->delete($id);

            Event::dispatch('catalog.product.delete.after', $id);

            return new JsonResponse([
                'message' => trans('admin::app.catalog.products.delete-success'),
            ]);
        } catch (\Exception $e) {
            report($e);
        }

        return new JsonResponse([
            'message' => trans('admin::app.catalog.products.delete-failed'),
        ], 500);
    }

    /**
     * Mass delete the products.
     */
    public function massDestroy(MassDestroyRequest $massDestroyRequest): JsonResponse
    {
        $productIds = $massDestroyRequest->input('indices');
        foreach ($productIds as $id) {
            /** @var Product $product */
            $product = $this->productRepository->findOrFail($id);

            /** @var Admin $admin */
            $admin = auth('admin')->user();
            if ($admin->isSeller() && $admin->getSellerId() != $product->getSellerId()) {
                abort(401, 'this action is unauthorized');
            }
        }
        try {
            foreach ($productIds as $productId) {
                $product = $this->productRepository->find($productId);

                if (isset($product)) {
                    Event::dispatch('catalog.product.delete.before', $productId);

                    $this->productRepository->delete($productId);

                    Event::dispatch('catalog.product.delete.after', $productId);
                }
            }

            return new JsonResponse([
                'message' => trans('admin::app.catalog.products.index.datagrid.mass-delete-success'),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mass update the products.
     */
    public function massUpdate(MassUpdateRequest $massUpdateRequest): JsonResponse
    {
        $data = $massUpdateRequest->all();

        $productIds = $data['indices'];

        foreach ($productIds as $id) {
            /** @var Product $product */
            $product = $this->productRepository->findOrFail($id);

            /** @var Admin $admin */
            $admin = auth('admin')->user();
            if ($admin->isSeller() && $admin->getSellerId() != $product->getSellerId()) {
                abort(401, 'this action is unauthorized');
            }
        }

        foreach ($productIds as $productId) {
            Event::dispatch('catalog.product.update.before', $productId);

            $product = $this->productRepository->update([
                'status' => $massUpdateRequest->input('value'),
            ], $productId);

            Event::dispatch('catalog.product.update.after', $product);
        }

        return new JsonResponse([
            'message' => trans('admin::app.catalog.products.index.datagrid.mass-update-success'),
        ], 200);
    }

    /**
     * To be manually invoked when data is seeded into products.
     *
     * @return RedirectResponse
     */
    public function sync(): RedirectResponse
    {
        Event::dispatch('products.datagrid.sync', true);

        return redirect()->route('admin.catalog.products.index');
    }

    /**
     * Result of search product.
     *
     * @return JsonResponse
     */
    public function search(): JsonResponse
    {
        $results = [];

        request()->query->add([
            'status' => null,
            'name'   => request('query'),
            'sort'   => 'created_at',
            'order'  => 'desc',
        ]);

        $products = $this->productRepository->searchFromDatabase();

        foreach ($products as $product) {
            $results[] = [
                'id'              => $product->id,
                'sku'             => $product->sku,
                'name'            => $product->name,
                'price'           => $product->price,
                'formatted_price' => core()->formatBasePrice($product->price),
                'images'          => $product->images,
                'inventories'     => $product->inventories,
            ];
        }

        $products->setCollection(collect($results));

        return response()->json($products);
    }

    /**
     * Download image or file.
     *
     * @param  int  $productId
     * @param  int  $attributeId
     * @return StreamedResponse
     */
    public function download($productId, $attributeId)
    {
        $productAttribute = $this->productAttributeValueRepository->findOneWhere([
            'product_id'   => $productId,
            'attribute_id' => $attributeId,
        ]);

        return Storage::download($productAttribute['text_value']);
    }

    public function updatePriceAndStock($id): RedirectResponse
    {
        request()->validate([
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'numeric', 'min:0'],
        ]);
        $newPrice = request()->get('price');
        $newStock = request()->get('stock');
        $admin = $this->getAuthenticatedAdmin();
        $product = $this->productRepository->findOrFail($id);
        if ($admin->isSeller() && $admin->getSellerId() != $product->getSellerId()) {
            abort(401, 'this action is unauthorized');
        }

        $this->productRepository->update(['price' => $newPrice, 'inventories' => [1 => $newStock], 'channel' => 'default'], $id, 'id', true);
        Event::dispatch('catalog.product.update.after', $product);

        return redirect()->route('admin.catalog.products.index');
    }
}
