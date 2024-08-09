@component('shop::emails.layout')
    <div style="margin-bottom: 34px;">
        <p style="font-weight: bold;font-size: 20px;color: #121A26;line-height: 24px;margin-bottom: 24px">
            @lang('shop::app.emails.dear', ['customer_name' => $customer['name']]), 👋
        </p>

        <p style="font-size: 16px;color: #384860;line-height: 24px;">
            @lang('shop::app.emails.customers.verification.greeting')
        </p>
    </div>

    <p style="font-size: 16px;color: #384860;line-height: 24px;margin-bottom: 40px">
        @lang('shop::app.emails.customers.verification.description')
    </p>

    <div style="display: flex;margin-bottom: 95px">
        <a
                href="{{ route($customer['seller'] ? 'shop.marketplace.verify-email' : 'shop.customers.verify' , $customer['token'])}}"
                style="color: #153939;background-color: #F67541;border-radius: 4px;padding: 10px 40px !important;font-size: 16px;font-family: 'Somar Sans Medium', sans-serif !important;"
        >
            @lang('shop::app.emails.customers.verification.verify-email')
        </a>
    </div>
@endcomponent
