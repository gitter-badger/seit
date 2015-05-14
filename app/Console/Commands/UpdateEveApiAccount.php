<?php namespace SeIT\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class UpdateEveApiAccount
 * @package SeIT\Console\Commands
 */
class UpdateEveApiAccount extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'task:update-eve-account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedules a update job for EVE -> Account-Endpoint';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Schedules an update for EvE Account XML endpoints.
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
                '\SeIT\Queues\EveApi\Account\Worker',
                $apiKey->keyID,
                $apiKey->vCode,
                'Account',
                'AccountStatus'
            );
        }
        
        \Log::info('Dispatched command ' . $this->name, array('src' => __CLASS__));
    }
}
