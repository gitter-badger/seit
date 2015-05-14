<?php namespace SeIT\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class UpdateEveApiCharacter
 * @package SeIT\Console\Commands
 */
class UpdateEveApiCharacter extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'task:update-eve-character';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedules a update job for EVE -> Character-Endpoint';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Schedules an update for EvE Character XML endpoints.
     *
     * @return void
     */
    public function fire()
    {
        \Log::info('Dispatching command ' . $this->name, array('src' => __CLASS__));

        $apiKeyList = \DB::Table('seit_keys')->where('isOk', true)->get();

        foreach ($apiKeyList as $apiKey) {
            \Log::info('Key Details: ', (array)$apiKey->keyID);

            \SeIT\Services\Queue::addEveApiJob(
                '\SeIT\Queues\EveApi\Char\Worker',
                $apiKey->keyID,
                $apiKey->vCode,
                'Character',
                ''
            );
        }
        
        \Log::info('Dispatched command ' . $this->name, array('src' => __CLASS__));
    }
}
