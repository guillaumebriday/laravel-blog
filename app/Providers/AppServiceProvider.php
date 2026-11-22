<?php

namespace App\Providers;

use App\Models\Media;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        Route::model('medium', Media::class);

        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));

        Blade::directive('humanize_date', fn (string $params): string => "<?php echo humanize_date($params); ?>");
        Blade::if('admin', fn (): bool => Auth::check() && Auth::user()->isAdmin());
        Blade::if('profile', fn ($user): bool => Auth::check() && Auth::id() == $user->id);
    }
}
