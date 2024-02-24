{!! view_render_event('bagisto.shop.layout.features.before') !!}

<!-- Features -->
<div class="container mt-20 max-lg:px-[30px] max-sm:mt-[30px]">
    <div class="flex gap-[25px] justify-center max-lg:flex-wrap">
        <div class="flex items-center gap-[20px]">
            <span class="flex items-center justify-center w-[60px] h-[60px] bg-white border sn-border-main rounded-full text-[42px] text-navyBlue p-[10px] {{trans('shop::app.footer.0.icon')}} sn-color-light-main"></span>

            <div class="">
                <p class="text-[16px] font-medium font-dmserif sn-color-light-main">{{trans('shop::app.footer.0.title')}}</p>

                <p class="text-[14px] font-medium mt-[10px] text-[#6E6E6E] max-w-[217px]">
                    {{trans('shop::app.footer.0.text')}}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-[20px]">
            <span class="flex items-center justify-center w-[60px] h-[60px] bg-white border sn-border-main rounded-full text-[42px] text-navyBlue p-[10px] {{trans('shop::app.footer.1.icon')}} sn-color-light-main"></span>
            <div class="">
                <p class="text-[16px] font-medium font-dmserif sn-color-light-main">{{trans('shop::app.footer.1.title')}}</p>
                <p class="text-[14px] font-medium mt-[10px] text-[#6E6E6E] max-w-[217px]">
                    {{trans('shop::app.footer.1.text')}}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-[20px]">
            <span class="flex items-center justify-center w-[60px] h-[60px] bg-white border sn-border-main rounded-full text-[42px] text-navyBlue p-[10px] {{trans('shop::app.footer.2.icon')}} sn-color-light-main"></span>

            <div class="">
                <p class="text-[16px] font-medium font-dmserif sn-color-light-main">{{trans('shop::app.footer.2.title')}}</p>

                <p class="text-[14px] font-medium mt-[10px] text-[#6E6E6E] max-w-[217px]">
                    {{trans('shop::app.footer.2.text')}}
                </p>
            </div>
        </div>
    </div>
</div>

{!! view_render_event('bagisto.shop.layout.features.after') !!}
