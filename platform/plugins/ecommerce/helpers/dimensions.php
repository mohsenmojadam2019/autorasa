<?php

use Botble\Ecommerce\Models\Dimension;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

if (! function_exists('get_featured_dimensions')) {
    function get_featured_dimensions(int $limit = 8, array $with = ['slugable'], array $withCount = []): Collection|LengthAwarePaginator
    {
        return Dimension::query()
//            ->where('is_featured', true)
            ->wherePublished()
//            ->orderBy('order')->latest()
            ->with($with)
            ->withCount($withCount)
            ->take($limit)
            ->get();
    }
}

if (! function_exists('get_all_dimensions')) {
    function get_all_dimensions(array $conditions = [], array $with = ['slugable'], array $withCount = []): Collection
    {
        return Dimension::query()
            ->where($conditions)
//            ->orderBy('order')->latest()
            ->with($with)
            ->withCount($withCount)
            ->get();
    }
}
