<?php

namespace Botble\Campaign\Facades;

use Botble\Campaign\Contracts\Factory;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getDefaultDriver()
 * @method static void registerCampaignPopup(bool $keepHtmlDomOnClose = false)
 * @method static mixed driver(string|null $driver = null)
 * @method static \Botble\Campaign\CampaignManager extend(string $driver, \Closure $callback)
 * @method static array getDrivers()
 * @method static \Illuminate\Contracts\Container\Container getContainer()
 *
 * @see \Botble\Campaign\CampaignManager
 */
class Campaign extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Factory::class;
    }
}
