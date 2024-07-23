@props(['title', 'post', 'image', 'seller'])
<a href="{{ route('shop.marketplace.show', $seller->slug) }}"
    class="flex flex-col max-w-[360px] sn-background-light-green-2 p-4 rounded-lg">
    <div class="sn-heading-2 sn-color-primary text-center pb-[21px]">
        {{ $seller['name'] }}
    </div>
    @if ($title != '')
        <div class="sn-heading-3 text-right sn-color-primary pb-1">
            {{ $title }}
        </div>
    @endif
    @if ($post != '')
        <div class="sn-body-1 pb-1">
            {{ $post }}
        </div>
    @endif
    @if ($image != '')
        <div class="">
            <img src="{{ $image }}" class="w-[360px] rounded-lg max-h-[360px] object-contain" />
        </div>
    @endif
</a>
