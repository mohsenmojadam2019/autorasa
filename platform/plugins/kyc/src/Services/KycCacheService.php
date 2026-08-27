<?php

namespace Botble\Kyc\Services;

use Botble\Kyc\Models\Kyc;
use Illuminate\Support\Facades\Cache;

class KycCacheService
{
    /**
     * Cache key for KYC entries.
     */
    protected const CACHE_KEY = 'kyc_entries';

    /**
     * Fetch all KYC entries from cache or database.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllKycEntries(): \Illuminate\Support\Collection
    {
        return Cache::remember(self::CACHE_KEY, 3600, function () {
            return Kyc::where('status', 'activate')->get();
        });
    }

    /**
     * Clear the KYC cache.
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
