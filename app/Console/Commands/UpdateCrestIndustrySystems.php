<?php namespace SeIT\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class UpdateCrestIndustrySystems
 * @package SeIT\Console\Commands
 */
class UpdateCrestIndustrySystems extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'task:update-crest-industry-systems';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedules a update job for Crest -> Industry/Systems';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Schedule an update for Crest endpoint of Industry->Systems
     *
     * @return void
     */
    public function fire()
    {
        \Log::info('Dispatching command ' . $this->name);
        \SeIT\Services\Queue::addCrestJob('\SeIT\Queues\Crest\IndustrySystemsUpdater');
        \Log::info('Dispatched command ' . $this->name);
    }
}
