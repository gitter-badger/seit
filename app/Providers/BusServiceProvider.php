<?php namespace SeIT\Providers;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;

/**
 * Class BusServiceProvider
 * @package SeIT\Providers
 */
class BusServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @param  \Illuminate\Bus\Dispatcher  $dispatcher
     * @return void
     */
    public function boot(Dispatcher $dispatcher)
    {
        $dispatcher->mapUsing(function ($command) {
            return Dispatcher::simpleMapping(
                $command,
                'SeIT\Commands',
                'SeIT\Handlers\Commands'
            );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
