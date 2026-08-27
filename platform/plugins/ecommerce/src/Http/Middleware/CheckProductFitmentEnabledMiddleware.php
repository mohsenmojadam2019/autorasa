<?php

namespace Botble\Ecommerce\Http\Middleware;

use Botble\Ecommerce\Facades\EcommerceHelper;
use Closure;
use Illuminate\Http\Request;

class CheckProductFitmentEnabledMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless(EcommerceHelper::isProductFitmentEnabled(), 404);

        return $next($request);
    }
}
