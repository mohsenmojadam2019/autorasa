<?php

namespace Botble\Ecommerce\Http\Controllers;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Supports\Pdf;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Facades\InvoiceHelper;
use Botble\Ecommerce\Models\Shipment;
use Botble\Location\Models\City;
use Botble\Location\Models\State;
use Botble\Media\Facades\RvMedia;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Mpdf\Mpdf;

class PrintShippingLabelController extends BaseController
{
//    public function __invoke(Shipment $shipment, Pdf $pdf): Response
//    {
//        $renderer = new ImageRenderer(
//            new RendererStyle(400),
//            new SvgImageBackEnd()
//        );
//
//        $writer = new Writer($renderer);
//
//        $url = $shipment->tracking_link;
//
//        if (! $url) {
//            $params = [
//                'order_id' => get_order_code($shipment->order_id),
//            ];
//
//            $customer = $shipment->order->user;
//
//            $orderAddress  = $shipment->order->address;
//
//            if (EcommerceHelper::isLoginUsingPhone()) {
//                $params['phone'] = $orderAddress->phone ?: $customer->phone;
//            } else {
//                $params['email'] = $orderAddress->email ?: $customer->email;
//            }
//
//            $url = route('public.orders.tracking', $params);
//        }
//
//        $qrCode = $writer->writeString($url);
//
//        $country = EcommerceHelper::getCountryNameById(get_ecommerce_setting('store_country'));
//        $state = get_ecommerce_setting('store_state');
//        $city = get_ecommerce_setting('store_city');
//
//        if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation()) {
//            if (is_numeric($state)) {
//                $state = State::query()->wherePublished()->where('id', $state)->value('name');
//            }
//
//            if (is_numeric($city)) {
//                $city = City::query()->wherePublished()->where('id', $city)->value('name');
//            }
//        }
//
//        $address = get_ecommerce_setting('store_address');
//
//        $zipCode = get_ecommerce_setting('store_zip_code');
//
//        $fullAddress = implode(', ', array_filter([
//            $address,
//            $city,
//            $state,
//            $country,
//            EcommerceHelper::isZipCodeEnabled() ? $zipCode : '',
//        ]));
//
//        $order = $shipment->order;
//
//        return $pdf
//            ->templatePath(plugin_path('ecommerce/resources/templates/shipping-label.tpl'))
//            ->destinationPath(storage_path('app/templates/ecommerce/shipping-label.tpl'))
//            ->paperSizeHalfLetter()
//            ->supportLanguage(InvoiceHelper::getLanguageSupport())
//            ->data(apply_filters('ecommerce_shipping_label_data', [
//                'shipment' => [
//                    'order_number' => get_order_code($shipment->order_id),
//                    'code' => get_shipment_code($shipment->getKey()),
//                    'weight' => $shipment->weight,
//                    'weight_unit' => ecommerce_weight_unit(),
//                    'created_at' => BaseHelper::formatDate($shipment->created_at),
//                    'shipping_method' => $order->shipping_method_name,
//                    'shipping_fee' => format_price($shipment->price),
//                    'shipping_company_name' => $shipment->shipping_company_name,
//                    'tracking_id' => $shipment->tracking_id,
//                    'tracking_link' => $shipment->tracking_link,
//                    'note' => Str::limit((string) $shipment->note, 90),
//                    'qr_code' => base64_encode($qrCode),
//                    'order' => [
//                        'amount' => format_price($order->amount),
//                        'tax_amount' => format_price($order->tax_amount),
//                        'shipping_amount' => format_price($order->shipping_amount),
//                        'discount_amount' => format_price($order->discount_amount),
//                        'sub_total' => format_price($order->sub_total),
//                    ],
//                ],
//                'sender' => [
//                    'logo' => RvMedia::getRealPath(Theme::getLogo()),
//                    'name' => get_ecommerce_setting('store_name'),
//                    'phone' => get_ecommerce_setting('store_phone'),
//                    'email' => get_ecommerce_setting('store_email'),
//                    'country' => $country,
//                    'state' => $state,
//                    'city' => $city,
//                    'zip_code' => $zipCode,
//                    'address' => $address,
//                    'full_address' => $fullAddress,
//                ],
//                'receiver' => [
//                    'name' => $order->user_name,
//                    'full_address' => $order->full_address,
//                    'email' => $order->user->email,
//                    'phone' => $order->user->phone,
//                    'note' => Str::limit((string) $order->description, 90),
//                ],
//            ], $shipment))
//            ->compile()
//            ->stream();
//    }
    public function __invoke(Shipment $shipment, Pdf $pdf): Response
    {
        $mpdf = new Mpdf([
            'default_font' => 'iransans',
        ]);

        // تولید QR کد
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);

        $url = $shipment->tracking_link;

        if (! $url) {
            $params = [
                'order_id' => get_order_code($shipment->order_id),
            ];

            $customer = $shipment->order->user;
            $orderAddress = $shipment->order->address;

            if (EcommerceHelper::isLoginUsingPhone()) {
                $params['phone'] = $orderAddress->phone ?: $customer->phone;
            } else {
                $params['email'] = $orderAddress->email ?: $customer->email;
            }

            $url = route('public.orders.tracking', $params);
        }

        $qrCode = base64_encode($writer->writeString($url));

        // آدرس فرستنده
        $country = EcommerceHelper::getCountryNameById(get_ecommerce_setting('store_country'));
        $state = get_ecommerce_setting('store_state');
        $city = get_ecommerce_setting('store_city');

        if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation()) {
            if (is_numeric($state)) {
                $state = State::query()->wherePublished()->where('id', $state)->value('name');
            }

            if (is_numeric($city)) {
                $city = City::query()->wherePublished()->where('id', $city)->value('name');
            }
        }

        $address = get_ecommerce_setting('store_address');
        $zipCode = get_ecommerce_setting('store_zip_code');

        $fullAddress = implode(', ', array_filter([
            $address,
            $city,
            $state,
            $country,
            EcommerceHelper::isZipCodeEnabled() ? $zipCode : '',
        ]));

        $order = $shipment->order;
        $logoLight = RvMedia::getImageUrl(theme_option('logo'));
//dd($shipment);
        $html = '
<html>
<head>
    <style>
        body {
            direction: rtl;
            font-family: iransans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #2c3e50;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header img {
            width: 60px;
            height: auto;
        }

        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .section {
            border: 1px solid #ddd;
            padding: 8px 10px;
            border-radius: 6px;
            margin-bottom: 12px;
            background-color: #fafafa;
        }

        .section h3 {
            margin: 0 0 6px;
            font-size: 13px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
        }

        .qr-container {
            text-align: center;
            margin-top: 10px;
        }

        .qr-container img {
            width: 80px;
            height: auto;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="' . $logoLight . '" alt="لوگو" style="width: 200px">
    </div>

    <div class="title">برچسب حمل و نقل</div>

    <table class="info-table">
        <tr>
            <td><strong>کد سفارش:</strong> ' . get_order_code($shipment->order_id) . '</td>
            <td><strong>کد محموله:</strong> ' . get_shipment_code($shipment->getKey()) . '</td>
        </tr>
        <tr>
            <td><strong>تاریخ ثبت:</strong> ' . BaseHelper::formatDate($shipment->created_at) . '</td>
            <td><strong>شرکت حمل:</strong> ' . $shipment->shipping_company_name . '</td>
        </tr>
        <tr>
            <td><strong>وزن محصول:</strong> ' . $shipment->weight . '</td>
            <td><strong>روش حمل:</strong> ' . $order->shipping_method_name . '</td>
            <td><strong>هزینه حمل:</strong> ' . format_price($shipment->price) . '</td>
        </tr>
    </table>

    <div class="section">
        <h3>فرستنده</h3>
        <p>
            <strong>' . get_ecommerce_setting('store_name') . '</strong><br>
            ' . $fullAddress . '<br>
            تلفن: ' . get_ecommerce_setting('store_phone') . '<br>
            ایمیل: ' . get_ecommerce_setting('store_email') . '
        </p>
    </div>

    <div class="section">
        <h3>گیرنده</h3>
        <p>
            <strong>' . $order->user_name . '</strong><br>
            ' . $order->full_address . '<br>
            تلفن: ' . $order->user->phone . '<br>
            ایمیل: ' . $order->user->email . '
        </p>
    </div>

    <div class="qr-container">
        <img src="data:image/svg+xml;base64,' . $qrCode . '" alt="QR Code" style="width: 200px">
    </div>

</body>
</html>';



        $mpdf->WriteHTML($html);
        return response($mpdf->Output('', 'S'), 200)
            ->header('Content-Type', 'application/pdf');
    }}
