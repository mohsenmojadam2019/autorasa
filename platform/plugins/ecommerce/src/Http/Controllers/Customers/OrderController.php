<?php

namespace Botble\Ecommerce\Http\Controllers\Customers;

use Botble\Ecommerce\Enums\OrderCancellationReasonEnum;
use Botble\Ecommerce\Enums\OrderHistoryActionEnum;
use Botble\Ecommerce\Facades\InvoiceHelper;
use Botble\Ecommerce\Facades\OrderHelper;
use Botble\Ecommerce\Forms\Fronts\CancelOrderForm;
use Botble\Ecommerce\Http\Controllers\BaseController;
use Botble\Ecommerce\Http\Requests\Fronts\CancelOrderRequest;
use Botble\Ecommerce\Models\Order;
use Botble\Ecommerce\Models\OrderHistory;
use Botble\Media\Facades\RvMedia;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class OrderController extends BaseController
{
    public function __construct()
    {
        $version = get_cms_version();

        Theme::asset()
            ->add('customer-style', 'vendor/core/plugins/ecommerce/css/customer.css', ['bootstrap-css'], version: $version);
        Theme::asset()
            ->add('front-ecommerce-css', 'vendor/core/plugins/ecommerce/css/front-ecommerce.css', version: $version);
    }

    public function index()
    {
        SeoHelper::setTitle(__('Orders'));

        $orders = Order::query()
            ->where([
                'user_id' => auth('customer')->id(),
                'is_finished' => 1,
            ])
            ->withCount(['products'])
            ->orderByDesc('created_at')
            ->paginate(10);

        Theme::breadcrumb()
            ->add(__('Orders'), route('customer.orders'));

        return Theme::scope(
            'ecommerce.customers.orders.list',
            compact('orders'),
            'plugins/ecommerce::themes.customers.orders.list'
        )->render();
    }

    public function show(int|string $id)
    {
        $order = Order::query()
            ->where([
                'id' => $id,
                'user_id' => auth('customer')->id(),
            ])
            ->with(['address', 'products'])
            ->firstOrFail();

        $cancelOrderForm = CancelOrderForm::createFromModel($order);

        SeoHelper::setTitle(__('Order detail :id', ['id' => $order->code]));

        Theme::breadcrumb()
            ->add(
                __('Order detail :id', ['id' => $order->code]),
                route('customer.orders.view', $id)
            );

        return Theme::scope(
            'ecommerce.customers.orders.view',
            compact('order', 'cancelOrderForm'),
            'plugins/ecommerce::themes.customers.orders.view'
        )->render();
    }

    public function destroy(int|string $id, CancelOrderRequest $request)
    {
        return $this->handleCancelOrder($id, $request->input('cancellation_reason'), $request->input('cancellation_reason_description'));
    }

    public function print(int|string $id, Request $request)
    {
        /**
         * @var Order $order
         */
        $order = Order::query()
            ->where([
                'id' => $id,
                'user_id' => auth('customer')->id(),
            ])->with(['address', 'products','payment'])
            ->firstOrFail();
        abort_unless($order->isInvoiceAvailable(), 404);
        if ($request->input('type') == 'print') {
            return $this->streamInvoice($order,$order->invoice);
//            return InvoiceHelper::streamInvoice($order->invoice);
        }
        return $this->downloadInvoice($order,$order->invoice);
//        return InvoiceHelper::downloadInvoice($order->invoice);
    }

    /**
     * @throws MpdfException
     */
    private function streamInvoice($order, $invoice = null)
    {
//        dd($order);
        $mpdf = new Mpdf([
            'default_font' => 'iransans',
        ]);

        $logoLight = RvMedia::getImageUrl(theme_option('logo'));
        $html = '
    <html>
    <body style="direction: rtl; font-family: iransans,sans-serif; font-size: 14px;">
        <div style="text-align: center; margin-bottom: 10px;">
          <img src="' . $logoLight . '" width="150"  alt=""/>
        </div>

        <h2 style="text-align: center;">صورتحساب خرید</h2>

        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td><strong>تاریخ فاکتور:</strong> ' . $order->invoice->paid_at . '</td>
                <td><strong>شماره فاکتور:</strong> ' . $order->code . '</td>
            </tr>
            <tr>
                <td><strong>نام مشتری:</strong> ' . $order->invoice->customer_name . '</td>
                <td><strong>شماره تماس:</strong> ' . $order->invoice->customer_phone . '</td>
            </tr>
            <tr>
                <td colspan="2"><strong>آدرس:</strong> ' . $order->invoice->customer_address . '</td>
            </tr>
        </table>

        <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
            <thead>
                <tr style="background-color: #eee;">
                    <th>محصول</th>
                    <th>تعداد</th>
                    <th>قیمت واحد (ریال)</th>
                    <th>قیمت کل (ریال)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>' . $order->products[0]->product_name . '</td>
                    <td>' . $order->products[0]->qty . '</td>
                    <td>' . number_format($order->products[0]->price) . '</td>
                    <td>' . number_format($order->sub_total) . '</td>
                </tr>
            </tbody>
        </table>

        <br/>
        <table style="width: 100%; font-size: 15px;">
            <tr>
                <td><strong>جمع کل:</strong></td>
                <td>' . number_format($order->invoice->sub_total) . ' ریال</td>
            </tr>
            <tr>
                <td><strong>هزینه حمل و نقل:</strong></td>
                <td>' . number_format($order->invoice->shipping_amount) . ' ریال</td>
            </tr>
            <tr>
                <td><strong>هزینه مالیات:</strong></td>
                <td>' . number_format($order->products[0]->tax_amount) . ' ریال</td>
            </tr>
            <tr>
                <td><strong>مبلغ نهایی:</strong></td>
                <td><strong>' . number_format($order->payment->amount) . ' ریال</strong></td>
            </tr>
            <tr>
                <td><strong>روش پرداخت:</strong></td>
                <td>' . $order->payment->payment_channel . '</td>
            </tr>
        </table>

        <br/><br/>
       <div style="text-align: center; margin-top: 40px;">
    <div style="
        display: inline-block;
        width: 130px;
        padding: 8px;
        border: 2px dashed green;
        color: green;
        font-weight: bold;
        font-size: 16px;
        transform: rotate(-15deg);
        border-radius: 8px;
        opacity: 0.85;
    ">
        خریداری شده
    </div>
</div>

    </body>
    </html>';

        $mpdf->WriteHTML($html);
        return response($mpdf->Output('', 'S'), 200)
            ->header('Content-Type', 'application/pdf');
    }

    /**
     * @throws MpdfException
     */
    private function downloadInvoice($order, $invoice = null)
    {
        $mpdf = new Mpdf([
            'default_font' => 'iransans',
        ]);

        $logoLight = RvMedia::getImageUrl(theme_option('logo'));

        $html = '
    <html>
    <body style="direction: rtl; font-family: iransans,sans-serif; font-size: 14px;">
        <div style="text-align: center; margin-bottom: 10px;">
          <img src="' . $logoLight . '" width="150"  alt=""/>
        </div>

        <h2 style="text-align: center;">صورتحساب خرید</h2>

        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td><strong>تاریخ فاکتور:</strong> ' . $order->invoice->paid_at . '</td>
                <td><strong>شماره فاکتور:</strong> ' . $order->code . '</td>
            </tr>
            <tr>
                <td><strong>نام مشتری:</strong> ' . $order->invoice->customer_name . '</td>
                <td><strong>شماره تماس:</strong> ' . $order->invoice->customer_phone . '</td>
            </tr>
            <tr>
                <td colspan="2"><strong>آدرس:</strong> ' . $order->invoice->customer_address . '</td>
            </tr>
        </table>

        <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
            <thead>
                <tr style="background-color: #eee;">
                    <th>محصول</th>
                    <th>تعداد</th>
                    <th>قیمت واحد (ریال)</th>
                    <th>قیمت کل (ریال)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>' . $order->products[0]->product_name . '</td>
                    <td>' . $order->products[0]->qty . '</td>
                    <td>' . number_format($order->products[0]->price) . '</td>
                    <td>' . number_format($order->sub_total) . '</td>
                </tr>
            </tbody>
        </table>

        <br/>
        <table style="width: 100%; font-size: 15px;">
            <tr>
                <td><strong>جمع کل:</strong></td>
                <td>' . number_format($order->invoice->sub_total) . ' ریال</td>
            </tr>
            <tr>
                <td><strong>هزینه حمل و نقل:</strong></td>
                <td>' . number_format($order->invoice->shipping_amount) . ' ریال</td>
            </tr>
            <tr>
                <td><strong>هزینه مالیات:</strong></td>
                <td>' . number_format($order->products[0]->tax_amount) . ' ریال</td>
            </tr>
            <tr>
                <td><strong>مبلغ نهایی:</strong></td>
                <td><strong>' . number_format($order->payment->amount) . ' ریال</strong></td>
            </tr>
            <tr>
                <td><strong>روش پرداخت:</strong></td>
                <td>' . $order->payment->payment_channel . '</td>
            </tr>
        </table>

        <br/><br/>
        <div style="text-align: center; margin-top: 40px;">
            <div style="
                display: inline-block;
                width: 130px;
                padding: 8px;
                border: 2px dashed green;
                color: green;
                font-weight: bold;
                font-size: 16px;
                transform: rotate(-15deg);
                border-radius: 8px;
                opacity: 0.85;
            ">
                خریداری شده
            </div>
        </div>
    </body>
    </html>';

        $mpdf->WriteHTML($html);
        $pdfContent = $mpdf->Output('', 'S');

        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="invoice_' . $order->code . '.pdf"');
    }
    public function getCancelOrder(int|string $id)
    {
        return $this->handleCancelOrder($id);
    }

    public function confirmDelivery(int|string $id)
    {
        /** @var Order $order */
        $order = Order::query()
            ->where('user_id', auth('customer')->id())
            ->findOrFail($id);

        if (! $order->shipment->can_confirm_delivery) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage(__('plugins/ecommerce::order.confirm_delivery_error'));
        }

        $order->shipment()->update([
            'customer_delivered_confirmed_at' => Carbon::now(),
        ]);

        OrderHistory::query()->create([
            'action' => OrderHistoryActionEnum::CONFIRM_DELIVERY,
            'description' => __('Order was confirmed delivery by customer :customer', ['customer' => $order->address->name ?: $order->user->name]),
            'order_id' => $order->getKey(),
        ]);

        return $this
            ->httpResponse()
            ->setMessage(__('plugins/ecommerce::order.confirm_delivery_success'));
    }

    protected function handleCancelOrder(int|string $id, ?string $reason = null, ?string $reasonDescription = null)
    {
        /** @var Order $order */
        $order = Order::query()
            ->where([
                'id' => $id,
                'user_id' => auth('customer')->id(),
            ])
            ->with(['address', 'products'])
            ->firstOrFail();

        if (! $order->canBeCanceled()) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage(trans('plugins/ecommerce::order.cancel_error'));
        }

        OrderHelper::cancelOrder($order, $reason, $reasonDescription);

        $customerName = $order->address->name ?: $order->user->name;

        $description = match (true) {
            $reason != OrderCancellationReasonEnum::OTHER => __('Order was cancelled by customer :customer with reason :reason', [
                'customer' => $customerName,
                'reason' => OrderCancellationReasonEnum::getLabel($reason),
            ]),
            $reason == OrderCancellationReasonEnum::OTHER => __('Order was cancelled by customer :customer with reason :reason', [
                'customer' => $customerName,
                'reason' => $reasonDescription,
            ]),
            default => __('Order was cancelled by customer :customer', ['customer' => $customerName]),
        };

        OrderHistory::query()->create([
            'action' => OrderHistoryActionEnum::CANCEL_ORDER,
            'description' => $description,
            'order_id' => $order->getKey(),
        ]);

        return $this
            ->httpResponse()
            ->setMessage(trans('plugins/ecommerce::order.cancel_success'));
    }
}
