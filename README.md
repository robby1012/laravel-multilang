# laravel-multilang
Implementation of multilanguage with Laravel Framework

Basic Premise:
- Add custom middleware to handle every URL request
- Register middleware to laravel kernal
- Inside custom middleware function check session for stored locale
- set laravel app locale to locale stored in session
- load requested URL


This sample use Laravel 9.X

```
php artisan make:middleware Localization
```

```
<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
class Localization
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle(Request $request, Closure $next)
    {
        if(Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
		else {
			App::setLocale('id');
		}
        return $next($request);
    }
}
```
app\Http\Kernel.php

```
protected $middlewareGroups = [
	'web' => [
		\App\Http\Middleware\EncryptCookies::class,
		\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
		\Illuminate\Session\Middleware\StartSession::class,
		\Illuminate\View\Middleware\ShareErrorsFromSession::class,
		\App\Http\Middleware\VerifyCsrfToken::class,
		\Illuminate\Routing\Middleware\SubstituteBindings::class,
		\App\Http\Middleware\Localization::class, <-- This our custom middleware
		],

	'api' => [
			// \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
			'throttle:api',
			\Illuminate\Routing\Middleware\SubstituteBindings::class,
		],
];
```

routes\web.php

```
Route::get('lang/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});
```