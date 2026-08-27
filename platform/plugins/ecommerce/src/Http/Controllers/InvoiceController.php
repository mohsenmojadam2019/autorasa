<?php

namespace Botble\Ecommerce\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Supports\Breadcrumb;
use Botble\Ecommerce\Facades\InvoiceHelper;
use Botble\Ecommerce\Models\Invoice;
use Botble\Ecommerce\Models\Order;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Tables\InvoiceTable;
use Botble\Media\Facades\RvMedia;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class InvoiceController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/ecommerce::invoice.name'), route('ecommerce.invoice.index'));
    }

    public function index(InvoiceTable $table)
    {
        $this->pageTitle(trans('plugins/ecommerce::invoice.name'));

        return $table->renderTable();
    }

    public function edit(Invoice $invoice, Request $request)
    {
        event(new BeforeEditContentEvent($request, $invoice));

        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $invoice->code]));

        return view('plugins/ecommerce::invoices.edit', compact('invoice'));
    }

    public function destroy(Invoice $invoice)
    {
        return DeleteResourceAction::make($invoice);
    }

    public function getGenerateInvoice(Invoice $invoice, Request $request)
    {
        $product = $invoice->items->first();
        $order = $invoice->payment->order;

        if ($request->input('type') === 'print') {
            return $this->streamInvoice($invoice,$invoice->payment,$product,$order);
//            return InvoiceHelper::streamInvoice($invoice);
        }

        return $this->downloadInvoice($invoice,$invoice->payment,$product,$order);
//        return InvoiceHelper::downloadInvoice($invoice);
    }
    private function streamInvoice($invoice, $payment = null, $product = null, $order = null)
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
                <td><strong>تاریخ فاکتور:</strong> ' . $invoice->paid_at . '</td>
                <td><strong>شماره فاکتور:</strong> ' . $order->code . '</td>
            </tr>
            <tr>
                <td><strong>نام مشتری:</strong> ' . $invoice->customer_name . '</td>
                <td><strong>شماره تماس:</strong> ' . $invoice->customer_phone . '</td>
            </tr>
            <tr>
                <td colspan="2"><strong>آدرس:</strong> ' . $invoice->customer_address . '</td>
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
                    <td>' . $product->name . '</td>
                    <td>' . $product->qty . '</td>
                    <td>' . number_format($product->price) . '</td>
                    <td>' . number_format($order->sub_total) . '</td>
                </tr>
            </tbody>
        </table>

        <br/>
        <table style="width: 100%; font-size: 15px;">
            <tr>
                <td><strong>جمع کل:</strong></td>
                <td>' . number_format($invoice->sub_total) . ' ریال</td>
            </tr>
            <tr>
                <td><strong>هزینه حمل و نقل:</strong></td>
                <td>' . number_format($invoice->shipping_amount) . ' ریال</td>
            </tr>
            <tr>
                <td><strong>هزینه مالیات:</strong></td>
                <td>' . number_format($invoice->tax_amount) . ' ریال</td>
            </tr>
            <tr>
                <td><strong>هزینه تخفیف:</strong></td>
                <td>' . number_format($invoice->discount_amount) . ' ریال</td>
            </tr>
            <tr>
                <td><strong>مبلغ نهایی:</strong></td>
                <td><strong>' . number_format($payment->amount) . ' ریال</strong></td>
            </tr>
            <tr>
                <td><strong>روش پرداخت:</strong></td>
                <td>' . $payment->payment_channel . '</td>
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
    private function downloadInvoice($invoice, $payment = null, $product = null, $order = null)
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
                <td><strong>تاریخ فاکتور:</strong> ' . $invoice->paid_at . '</td>
                <td><strong>شماره فاکتور:</strong> ' . $order->code . '</td>
            </tr>
            <tr>
                <td><strong>نام مشتری:</strong> ' . $invoice->customer_name . '</td>
                <td><strong>شماره تماس:</strong> ' . $invoice->customer_phone . '</td>
            </tr>
            <tr>
                <td colspan="2"><strong>آدرس:</strong> ' . $invoice->customer_address . '</td>
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
                    <td>' . $product->name . '</td>
                    <td>' . $product->qty . '</td>
                    <td>' . number_format($product->price) . '</td>
                    <td>' . number_format($order->sub_total) . '</td>
                </tr>
            </tbody>
        </table>

        <br/>
        <table style="width: 100%; font-size: 15px;">
            <tr>
                <td><strong>جمع کل:</strong></td>
                <td>' . number_format($invoice->sub_total) . ' ریال</td>
            </tr>
            <tr>
                <td><strong>هزینه حمل و نقل:</strong></td>
                <td>' . number_format($invoice->shipping_amount) . ' ریال</td>
            </tr>
            <tr>
                <td><strong>هزینه مالیات:</strong></td>
                <td>' . number_format($invoice->tax_amount) . ' ریال</td>
            </tr>
            <tr>
                <td><strong>هزینه تخفیف:</strong></td>
                <td>' . number_format($invoice->discount_amount) . ' ریال</td>
            </tr>
            <tr>
                <td><strong>مبلغ نهایی:</strong></td>
                <td><strong>' . number_format($payment->amount) . ' ریال</strong></td>
            </tr>
            <tr>
                <td><strong>روش پرداخت:</strong></td>
                <td>' . $payment->payment_channel . '</td>
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

        return response($mpdf->Output('', 'D'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="invoice.pdf"');
    }
    public function generateInvoices()
    {
        $orders = Order::query()
            ->where('is_finished', true)
            ->doesntHave('invoice')
            ->get();

        foreach ($orders as $order) {
            /**
             * @var Order $order
             */
            InvoiceHelper::store($order);
        }

        $message = trans('plugins/ecommerce::invoice.generate_success_message', ['count' => $orders->count()]);

        if ($orders->isEmpty()) {
            $message = trans('plugins/ecommerce::invoice.all_invoices_have_already_generated');
        }

        return $this
            ->httpResponse()
            ->setNextUrl(route('ecommerce.invoice.index'))
            ->setMessage($message);
    }
}
