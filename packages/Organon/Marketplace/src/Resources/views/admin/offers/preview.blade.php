<x-admin::layouts>
    <x-slot:title>
        @lang('marketplace::app.admin.offers.preview.title')
    </x-slot:title>

        <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
            <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
                @lang('marketplace::app.admin.offers.preview.title')
            </p>
            <a href="{{route('admin.offers.edit', ['id' => $model->id])}}" class="primary-button">
                @lang('marketplace::app.admin.offers.preview.edit')
            </a>
        </div>


        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">
            <x-shop::offer :title="$model->title" :post="$model->post" :image="$model->image_url" :seller="$model->seller" :product="$model->product?->sku"></x-shop::offer>
        </div>


</x-admin::layouts>
