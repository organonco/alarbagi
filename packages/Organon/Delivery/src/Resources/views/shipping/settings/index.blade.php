<x-delivery::layouts.shipping>
    <div class="card">
        <div class="header">
            الاعدادات
        </div>
        <hr/>
        <div class="description">
            تعديل رسوم التوصيل
        </div>
        <div class="content">
            <form method="POST" action="{{route('shipping.settings.store')}}">
                @csrf
                <div class="input">
                    <label for="per_order_price">رسم التوصيل على كل كيلومتر واحد</label>
                    <input type="text" name="km_price" value="{{$km_price}}"/>
                </div>
                <button type="submit" class="button-primary mt-4 sn-heading-3">حفظ</button>
            </form>
        </div>
    </div>
</x-delivery::layouts.shipping>