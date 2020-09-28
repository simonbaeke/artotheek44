@component('mail::message')
    # Order Shipped

    Your order has been shipped!



    Thanks,<br>
    {{ config('app.name') }}
@endcomponent


@component('mail::footer')
    © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
