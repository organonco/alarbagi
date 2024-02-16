{!! view_render_event('bagisto.admin.catalog.product.edit.form.images.before', ['product' => $product]) !!}

@php($hasError = false)
@foreach($errors->all() as $error)
    @if(\Illuminate\Support\Str::startsWith($error, "The image"))
        @php($hasError = true)
        @break;
    @endif
@endforeach


<div class="relative p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow" style="{{$hasError? "border: solid red 1px" : ""}}">
    <!-- Panel Header -->
    <div class="flex gap-[20px] justify-between mb-[16px]">
        <div class="flex flex-col gap-[8px]">
            <p class="text-[16px] text-gray-800 dark:text-white font-semibold">
                @lang('admin::app.catalog.products.edit.images.title')
            </p>

            <p class="text-[12px] text-gray-500 dark:text-gray-300 font-medium">
                @lang('admin::app.catalog.products.edit.images.info')
            </p>
        </div>
    </div>

    <!-- Image Blade Component -->

    <x-admin::media.images
        name="images[files]"
        allow-multiple="true"
        show-placeholders="true"
        :uploaded-images="$product->images"
    >
    </x-admin::media.images>
    @if($hasError)
        <div style="color: rgb(220 38 38); font-size: .75rem; margin-top: 10px">The Image Dimensions Are Not 1/1</div>
    @endif
</div>

{!! view_render_event('bagisto.admin.catalog.product.edit.form.images.after', ['product' => $product]) !!}
