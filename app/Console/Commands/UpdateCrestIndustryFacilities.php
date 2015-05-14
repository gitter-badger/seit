<?php namespace SeIT\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class UpdateCrestIndustryFacilities
 * @package SeIT\Console\Commands
 */
class UpdateCrestIndustryFacilities extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'task:update-crest-industry-facilities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedules a update job for Crest -> Industry/Facilities';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Schedule an update for Crest endpoint of Industry->Facilities
     *
     * @return void
     */
    public function fire()
    {
        \Log::info('Dispatching command ' . $this->name, array('src' => __CLASS__));
        \SeIT\Services\Queue::addCrestJob('\SeIT\Queues\Crest\IndustryFacilitiesUpdater');
        \Log::info('Dispatched command ' . $this->name, array('src' => __CLASS__));
    }
}
