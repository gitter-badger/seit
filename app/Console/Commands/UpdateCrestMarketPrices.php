<?php namespace SeIT\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class UpdateCrestMarketPrices
 * @package SeIT\Console\Commands
 */
class UpdateCrestMarketPrices extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'task:update-crest-market-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedules a update job for Crest -> Market/Prices';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Schedule an update for Crest endpoint of Market->Prices
     *
     * @return void
     */
    public function fire()
    {
        \Log::info('Dispatching command ' . $this->name);
        \SeIT\Services\Queue::addCrestJob('\SeIT\Queues\Crest\MarketPricesUpdater');
        \Log::info('Dispatched command ' . $this->name);
    }
}
