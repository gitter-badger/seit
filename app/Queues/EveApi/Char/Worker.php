<?php namespace SeIT\Queues\EveApi\Char;

use Illuminate\Contracts\Queue\Job;

/**
* Worker Class receives the fire() event and hands over the real API Handling to sub-classes for segmentation of worker
*/

class Worker
{
    /**
     *
     */
    public function __construct()
    {
        \Log::info(__CLASS__ . ': Worker started');
    }

    public function __destruct()
    {
        \Log::info(__CLASS__ . ': Worker finished');
    }

    /**
     * @param Job $job
     * @return bool
     */
    public static function fire(Job $job)
    {
        $job_record = \SeIT\Models\QueueInformation::where('jobID', '=', $job->getJobId())->first();

        if (!$job_record) {
            $job->release(5);
            return false;
        }
        try {
            // Worker Code starts here
            CharacterSheet::update($job_record->keyID, $job_record->vCode);

            Blueprints::update($job_record->keyID, $job_record->vCode);

            IndustryJobs::update($job_record->keyID, $job_record->vCode);

            // If worker is successful
            $job_record->status = 'Done';
            $job_record->save();
            $job->delete();
            return true;
        } catch (\Exception $e) {
            // If worker runs in Exception

            \Log::error('An error occured.', array($e));

            $job_record->status = 'Error';
            $job_record->output = 'Last status: ' . $job_record->output . PHP_EOL .
                'Error: ' . $e->getCode() . ': ' . $e->getMessage() . PHP_EOL .
                'File: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL .
                'Trace: ' . $e->getTraceAsString() . PHP_EOL .
                'Previous: ' . $e->getPrevious();
            $job_record->save();
            $job->delete();
            return false;
        }
    }
}
