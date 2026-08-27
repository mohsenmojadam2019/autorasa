<?php

namespace Botble\Ecommerce\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface DimensionInterface extends RepositoryInterface
{
    public function getAll(array $condition = []): Collection;
}
