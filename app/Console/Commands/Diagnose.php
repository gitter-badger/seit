<?php namespace SeIT\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class Diagnose
 * @package SeIT\Console\Commands
 */
class Diagnose extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'seit:diagnose';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs Diagnose task(s)';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This is a diagnose command to test various things.
     * Currenty checks EvE Crest connection.
     */
    public function fire()
    {
        
    }
}
