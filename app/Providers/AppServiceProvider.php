<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        date_default_timezone_set('America/Bogota');
        setlocale(LC_ALL, 'es_MX', 'es', 'ES', "es_ES");
        Carbon::setlocale(config('app.locale'));
        Schema::defaultStringLength(191);
        Blade::directive('money', function ($amount) {
            return "<?php echo '<i class=\"fas fa-dollar-sign\"></i> ' . number_format($amount, 0); ?>";
        });
    }
}
