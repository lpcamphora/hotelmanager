<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        /*if ($this->app->environment() !== 'production') {
            $this->app->register(\Way\Generators\GeneratorsServiceProvider::class);
            $this->app->register(\Xethron\MigrationsGenerator\MigrationsGeneratorServiceProvider::class);
        }        */
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        date_default_timezone_set('UTC');

        Blade::directive('convert', function ($money) {
            return "<?php echo number_format($money, 2, ',', '.'); ?>";
        });        

        Blade::directive('payment', function ($val) {
            $name = '';
            switch ($val) {
                case 1:
                    $name = 'Dinheiro';
                    break;
                case 2:
                    $name = 'Cartão de Crédito';
                    break;
                case 3:
                    $name = 'Cartão de Débito';
                    break;
                case 4:
                    $name = 'PIX';
                    break;
            }
            return "<?php echo $name; ?>";
        });        


    }
}
