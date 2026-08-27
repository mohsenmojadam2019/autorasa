@if ($payment)
    <p><span>{{ trans('plugins/payment::payment.payment_id') }}: </span>
        <a
            href="https://bpm.shaparak.ir.com/#/transactions/{{ Arr::get($payment, 'id') }}"
            target="_blank"
            rel="noopener noreferrer"
        >Edit Needed {{ Arr::get($payment, 'id') }}</a>
    </p>
    <p>{{ trans('plugins/payment::payment.amount') }}: {{ Arr::get($payment, 'amount') / 100 }}
        {{ Arr::get($payment, 'currency') }}</p>
    <p>{{ trans('plugins/payment::payment.email') }}: {{ Arr::get($payment, 'customer.email') }}</p>
    <p>{{ trans('core/base::tables.created_at') }}: {{ BaseHelper::formatDate(Arr::get($payment, 'created_at')) }}
    </p>
    <hr>

    @if ($refunds = Arr::get($paymentModel->metadata, 'refunds', []))
        <h6 class="alert-heading">{{ trans('plugins/payment::payment.amount_refunded') }}:
            {{ collect($refunds)->sum('_data_request.refund_amount') }}</h6>
        @foreach ($refunds as $refund)
            <div id="{{ Arr::get($refund, 'data.id') }}">
                @include('plugins/shetabit::refund-detail')
            </div>
        @endforeach
    @endif

    @include('plugins/payment::partials.view-payment-source')
@endif
