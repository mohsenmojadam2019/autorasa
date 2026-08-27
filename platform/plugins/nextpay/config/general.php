<?php

use Botble\Menu\Models\Menu;
use Botble\Menu\Models\MenuNode;
use Botble\Page\Models\Page;

return [
    'baseUrl' => 'https://nextpay.org/nx/gateway/',
    'apiPurchaseUrl' => 'https://nextpay.org/nx/gateway/token',
    'apiPaymentUrl' => 'https://nextpay.org/nx/gateway/payment/',
    'apiVerificationUrl' => 'https://nextpay.org/nx/gateway/verify',
    'merchantId' => 'b11ee9c3-d23d-414e-8b6e-f2370baac97b',
    'callbackUrl' => 'http://yoursite.com/path/to',
    'description' => 'payment using nextpay',
    'currency' => 'T', //Can be R, T (Rial, Toman)
];
