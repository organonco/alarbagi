<x-admin::layouts>
    <x-slot:title>
        @lang('marketplace::app.admin.offers.preview.title')
    </x-slot:title>

        <div class="flex  gap-[16px] justify-between items-center max-sm:flex-wrap">
            <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
                @lang('marketplace::app.admin.offers.preview.title')
            </p>
            <a href="{{route('admin.offers.edit', ['id' => $model->id])}}" class="primary-button">
                @lang('marketplace::app.admin.offers.preview.edit')
            </a>
        </div>


        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">

            <div class=" flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="w-full flex justify-center" >
                        <div class="bg-white p-[16px] flex flex-col gap-[8px]" style="border: 1px solid black;">
                            @if($model->title)
                                <div class="text-center" style="font-size: 40px">{{$model->title}}</div>
                            @endif
                            @if($model->post)
                                <div class="text-center">{{$model->post}}</div>
                            @endif
                            @if($model->image_url)
                                <img src="{{$model->image_url}}" style="height: 200px; width: auto; padding-top: 20px"/>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>


</x-admin::layouts>
