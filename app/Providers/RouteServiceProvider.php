<?php

namespace App\Providers;

use ArchiElite\UrlRedirector\Models\UrlRedirector;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
//        dd(UrlRedirector::all(),$request);
        if (is_plugin_active('Redirector')){
            $nextUrl = request()->getPathInfo();
            $findUrl = UrlRedirector::where(function ($query) use ($nextUrl) {
                $query->where('original', 'like', '%'. $nextUrl. '%');
            })->first();
            if ($findUrl) {
                if ($findUrl->target){
                    app()->make('redirect')->to($findUrl->target)->send();
                    exit;
                }else{
                    abort_unless($findUrl, 410);
                    exit;
                }
            }
        }
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
