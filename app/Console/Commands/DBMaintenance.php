<?php namespace SeIT\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class DBMaintenance
 * @package SeIT\Console\Commands
 */
class DBMaintenance extends Command
{

    use DispatchesCommands;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'task:database-maintenance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears down queue_information table of items in failed_jobs table';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Command to manual check the failed_jobs Table and clear down queue_information Table for old jobs.
     *
     * @return mixed
     */
    public function fire()
    {
        $result = \DB::Table('failed_jobs')->orderBy('failed_at')->get();
        
        foreach ($result as $e) {
            $pl = json_decode($e->payload);
            $this->info(
                'Job with ID ' . $pl->id . ' failed at ' . $e->failed_at .
                ' after ' . $pl->attempts . ' attempts for ' . $pl->job
            );

            \SeIT\Models\QueueInformation::where('jobID', '=', $pl->id)
            ->update(
                array(
                    'status' => 'Error',
                    'output' => 'Job ' . $pl->id . ' failed @ ' . $e->failed_at . ' after ' . $pl->attempts,
                    )
            );
            $fail_record = \SeIT\Models\FailedJobs::where('id', '=', $e->id);
            $fail_record->delete();
        }

        // truncate only if table is empty
        if (\DB::Table('failed_jobs')->count() < 1) {
            \DB::Table('failed_jobs')->truncate();
        }

        \DB::Table('queue_information')->where('updated_at', '<=', \Carbon\Carbon::now()->subDays(7))->delete();
    }
}
