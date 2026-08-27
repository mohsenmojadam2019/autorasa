<?php

namespace Botble\Kyc\Http\Middleware;

use Botble\Kyc\Enums\KycEnum;
use Botble\Kyc\Services\KycCacheService;
use Botble\Kyc\Services\KycValidationService;
use Botble\Kyc\Traits\DetectGuard;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfModelHasNotKYC
{
    use DetectGuard;

    protected KycCacheService $kycCacheService;
    private KycValidationService $kycValidationService;

    public function __construct(KycCacheService $kycCacheService, KycValidationService $kycValidationService)
    {
        $this->kycCacheService = $kycCacheService;
        $this->kycValidationService = $kycValidationService;
    }

    public function handle(Request $request, Closure $next, string $guard = null)
    {

        $guard = $this->detectGuard();

        $routeName = $request->route()->getName();

        // Check if the route name exists in the KYC entries
        $kycEntries = $this->kycCacheService->getAllKycEntries();
        $matchingKyc = $kycEntries->first(function ($entry) use ($routeName) {
            // Skip entries where route_name_pattern is null
            // dd($entry,$routeName);

            return $entry->route_name_pattern !== null && str_starts_with($routeName, $entry->route_name_pattern);
        });

        if (!$matchingKyc) {
            // If no matching KYC entry is found, skip the middleware
            return $next($request);
        }

        // Check if the user is authenticated
        if (!Auth::guard($guard)->check()) {
            $redirectRoute = $matchingKyc->redirect_if_not_logged_in ?? 'customer.login';
            return redirect()->guest(route($redirectRoute));
        }
        session()->put('redirect_back_url', $request->url());

        $authenticatedModel = Auth::guard($guard)->user();
        $modelClass = strtolower(class_basename($authenticatedModel));

        // Check the KYC status of the authenticated model
        $kycStatus = $this->kycValidationService->getKycStatus($modelClass, $authenticatedModel->id);

        if ($kycStatus === KycEnum::KYC_COMPLETED) {
            return $next($request); // Proceed if KYC is completed
        }
        // Redirect based on KYC status
//        session(['kyc_current_step' => 1]);

        return redirect()->route('public.kyc.list'); // Redirect to KYC page
    }

    /**
     * Get the redirect route for unauthenticated users.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function getRedirectRouteForGuest(Request $request): string
    {
        $kycEntries = $this->kycCacheService->getAllKycEntries();
        $matchingKyc = $kycEntries->first(function ($entry) use ($request) {
            return $request->route()->getName() && str_starts_with($request->route()->getName(), $entry->route_name_pattern);
        });

        return $matchingKyc?->redirect_if_not_logged_in ?? 'customer.login';
    }
}
