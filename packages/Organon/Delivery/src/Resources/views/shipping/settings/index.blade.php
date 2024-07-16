<x-delivery::layouts.shipping>
    <div class="card">
        <div class="header">
            رسوم التوصيل الحالية
        </div>
        <div class="content">
            <div>
                توصيل منتج واحد: {{$per_order_price + ($per_product_price)}} ل.س
            </div>
            <div>
                توصيل منتجين : {{$per_order_price + ($per_product_price * 2)}} ل.س
            </div>
            <div>
                توصيل  3 منتجات: {{$per_order_price + ($per_product_price * 3)}} ل.س
            </div>
            <div>
                توصيل  4منتجات: {{$per_order_price + ($per_product_price * 4)}} ل.س
            </div>
        </div>
    </div>
    <div class="card">
        <div class="header">
            الاعدادات
        </div>
        <div class="description">
            تعديل رسوم التوصيل
        </div>
        <div class="content">
            <form method="POST" action="{{route('shipping.settings.store')}}">
                @csrf
                <div class="input">
                    <label for="per_order_price">رسم التوصيل على كل طلب</label>
                    <input type="text" name="per_order_price" value="{{$per_order_price}}"/>
                </div>
                <div class="input">
                    <label for="per_product_price">رسم التوصيل على كل منتج</label>
                    <input type="text" name="per_product_price" value="{{$per_product_price}}"/>
                </div>
                <button type="submit" class="button-primary mt-4 sn-heading-3">حفظ</button>
            </form>
        </div>
    </div>
</x-delivery::layouts.shipping>