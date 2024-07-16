<x-delivery::layouts.shipping>
    <div class="card">
        <div class="header">
            تعديل السائق
        </div>
        <hr/>
        <div class="content">
            <form method="POST" action="{{route('shipping.driver.update', $driver->id)}}">
                @csrf
                <div class="input">
                    <div class="input">
                        <label for="name">اسم السائق</label>
                        <input type="text" name="name" value="{{$driver->name}}"/>
                    </div>
                    <div class="input">
                        <label for="phone">رقم الهاتف مسبوقاً بـ <span dir="ltr">+963</span></label>
                        <input type="text" name="phone" dir="ltr" class="text-right" value="{{$driver->phone}}"/>
                    </div>
                    <div class="input">
                        <label for="info">معلومات إضافية</label>
                        <input type="text" name="info" value="{{$driver->info}}"/>
                    </div>
                    <button type="submit" class="button-primary mt-6">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</x-delivery::layouts.shipping>
