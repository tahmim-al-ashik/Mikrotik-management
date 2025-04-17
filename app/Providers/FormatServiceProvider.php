<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class FormatServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        Blade::directive('bytes', function ($expression) {
            return "<?php echo App\Helpers\FormatHelper::bytes($expression); ?>";
        });
    }
}
