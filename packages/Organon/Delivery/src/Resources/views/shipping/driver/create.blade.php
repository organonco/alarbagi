<x-delivery::layouts.shipping>
    <div class="card">
        <div class="header">
            سائق جديد
        </div>
        <hr/>
        <div class="content">
            <form method="POST" action="{{route('shipping.driver.store')}}">
                @csrf
                <div class="input">
                    <div class="input">
                        <label for="name">اسم السائق</label>
                        <input type="text" name="name" />
                    </div>
                    <div class="input">
                        <label for="phone">رقم الهاتف مسبوقاً بـ <span dir="ltr">+963</span></label>
                        <input type="text" name="phone" dir="ltr" class="text-right"/>
                    </div>
                    <div class="input">
                        <label for="info">معلومات إضافية</label>
                        <input type="text" name="info" />
                    </div>
                    <button type="submit" class="button-primary mt-6">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</x-delivery::layouts.shipping>
