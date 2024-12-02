@props(['title', 'post', 'image', 'seller'])
<a href="{{ route('shop.marketplace.show', $seller->slug) }}"
    class="flex flex-col max-w-[360px] sn-background-light-green p-4 rounded-lg">
    <div class="text-2xl font-medium first-line:sn-color-primary sn-background-secondary w-fit px-4 py-2 mb-4 rounded-lg" style="color: white" >
        {{ $seller['name'] }}
    </div>
    @if ($title != '')
        <div class="text-base font-bold text-right sn-color-primary pb-1">
            {{ $title }}
        </div>
    @endif
    @if ($post != '')
        <div class="text-xs pb-3" style="word-break: break-word">
            {{ $post }}
        </div>
    @endif
    @if ($image != '')
        <div class="pt-2">
            <img src="{{ $image }}" class="w-[360px] rounded-lg max-h-[360px] object-contain shadow-md" />
        </div>
    @endif
</a>
