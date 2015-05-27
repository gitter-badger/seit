<?php namespace SeIT\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class UpdateEntityNamesMap
 * @package SeIT\Console\Commands
 */
class UpdateEveEntityNamesMap extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'task:update-eve-entity-names-map';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedules a update job for resolving missing entity names';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Checks for unresolved entities in the DB and processes them against EvE ID2Name Api
     *
     * @return void
     */
    public function fire()
    {
        // only push the trigger if there is something to resolve
        if (\SeIT\Models\SeITEntityNamesMap::where('resolved', '=', false)->count() > 0) {
            \Log::info('Dispatching command ' . $this->name);
            \SeIT\Services\Queue::addEveApiJob('\SeIT\Queues\EveApi\Services\ResolveEntityNames');
            \Log::info('Dispatched command ' . $this->name);
        }
    }
}
