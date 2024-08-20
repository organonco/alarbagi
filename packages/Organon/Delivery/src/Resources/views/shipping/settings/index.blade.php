<x-delivery::layouts.shipping>
    <div class="card">
        <div class="header">
            أمثلة عن رسوم التوصيل الحالية
        </div>
        <hr/>
        <div class="content">
            <div>
                توصيل من تاجر واحد: {{$per_order_price + ($per_product_price)}} ل.س 
            </div>
            <div>
                توصيل من تاجرين : {{$per_order_price + ($per_product_price * 2)}} ل.س
            </div>
            <div>
                توصيل  من 3 تجار: {{$per_order_price + ($per_product_price * 3)}} ل.س
            </div>
            <div>
                توصيل من 4 تجار: {{$per_order_price + ($per_product_price * 4)}} ل.س
            </div>
        </div>
    </div>
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
                    <label for="per_order_price">رسم التوصيل على كل طلب</label>
                    <input type="text" name="per_order_price" value="{{$per_order_price}}"/>
                </div>
                <div class="input">
                    <label for="per_product_price">رسم التوصيل على كل تاجر</label>
                    <input type="text" name="per_product_price" value="{{$per_product_price}}"/>
                </div>
                <button type="submit" class="button-primary mt-4 sn-heading-3">حفظ</button>
            </form>
        </div>
    </div>
</x-delivery::layouts.shipping>