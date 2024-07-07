@if ($prices['final']['price'] < $prices['regular']['price'])
    <p class=" line-through">
        {{ $prices['regular']['formatted_price'] }}
    </p>

    <p class="">
        {{ $prices['final']['formatted_price'] }}
    </p>
@else
    <p class="">
        {{ $prices['regular']['formatted_price'] }}
    </p>
@endif