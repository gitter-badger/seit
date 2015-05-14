<?php namespace SeIT\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class UpdateCrestAll
 * @package SeIT\Console\Commands
 */
class UpdateCrestAll extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'seit:update-crest-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedules a update job for Crest -> All Endpoints';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Schedules an update of all Crest endpoints into the queueing system.
     *
     * @return void
     */
    public function fire()
    {
        $this->info('Dispatching command ' . $this->name, array('src' => __CLASS__));
        \SeIT\Services\Queue::addCrestJob('\SeIT\Queues\Crest\IndustryFacilitiesUpdater');
        \SeIT\Services\Queue::addCrestJob('\SeIT\Queues\Crest\IndustrySystemsUpdater');
        \SeIT\Services\Queue::addCrestJob('\SeIT\Queues\Crest\MarketPricesUpdater');
        $this->info('Dispatched command ' . $this->name, array('src' => __CLASS__));
    }
}
