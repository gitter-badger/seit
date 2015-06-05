<?php namespace SeIT\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 * @package SeIT\Console
 */
class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        /* CREST */
        'SeIT\Console\Commands\DBMaintenance',
        'SeIT\Console\Commands\Diagnose',
        'SeIT\Console\Commands\UpdateCrestAll',
        'SeIT\Console\Commands\UpdateCrestIndustrySystems',
        'SeIT\Console\Commands\UpdateCrestIndustryFacilities',
        'SeIT\Console\Commands\UpdateCrestMarketPrices',
        /* XML API */
        'SeIT\Console\Commands\UpdateEveApiAccount',
        'SeIT\Console\Commands\UpdateEveApiCharacter',
        'SeIT\Console\Commands\UpdateEveEntityNamesMap',
        /* SDE Updater */
        'SeIT\Console\Commands\UpdateSDEData',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('task:update-crest-market-prices')->cron('40 1 * * * *');
        $schedule->command('task:update-crest-industry-facilities')->cron('51 */1 * * * *');
        $schedule->command('task:update-crest-industry-systems')->cron('52 */1 * * * *');
        $schedule->command('task:update-eve-entity-names-map')->cron('*/5 * * * * *');
        $schedule->command('task:update-eve-entity-names-map')->cron('*/5 * * * * *');
        $schedule->command('task:update-eve-account')->cron('41 */1 * * * *');
        $schedule->command('task:update-eve-character')->cron('42 */1 * * * *');
    }
}
