<?php

namespace Botble\Ecommerce\Http\Resources\API;

use Botble\Ecommerce\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Order
 */
class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'status_html' => $this->status->toHtml(),
            'customer' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ],
            'created_at' => $this->created_at,
//            'created_at' => $this->created_at->translatedFormat('Y-m-d\TH:i:sP'),
            'amount' => $this->amount,
            'amount_formated' => format_price($this->amount),
            'tax_amount' => $this->tax_amount,
            'tax_amount_formatted' => format_price($this->tax_amount),
            'shipping_amount' => $this->shipping_amount,
            'shipping_amount_formatted' => format_price($this->shipping_amount),
            'payment_id' => $this->payment_id,
        ];
    }
}
