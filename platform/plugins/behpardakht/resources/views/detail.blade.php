@if ($payment)
    <p><span>{{ trans('plugins/payment::payment.payment_id') }}: </span>{{ Arr::get($payment, 'reference_id') ?: Arr::get($payment, 'transaction_id') }}</p>
    <p>{{ trans('plugins/payment::payment.amount') }}: {{ Arr::get($payment, 'amount') }} {{ Arr::get($payment, 'currency') }}</p>
    <p>{{ trans('core/base::tables.created_at') }}: {{ BaseHelper::formatDate(Arr::get($payment, 'created_at')) }}</p>
    <hr>
    @include('plugins/payment::partials.view-payment-source')
@endif
