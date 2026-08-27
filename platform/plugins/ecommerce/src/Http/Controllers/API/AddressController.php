<?php

namespace Botble\Ecommerce\Http\Controllers\API;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Ecommerce\Http\Resources\API\AddressResource;
use Botble\Ecommerce\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends BaseController
{
    /**
     * Get list of address by customer
     *
     * @group Address
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $addresses = Address::query()
            ->where('customer_id', $request->user()->id)
            ->orderByDesc('is_default')
            ->latest()
            ->paginate(10);

        return $this
            ->httpResponse()
            ->setData(AddressResource::collection($addresses))
            ->toApiResponse();
    }
}
