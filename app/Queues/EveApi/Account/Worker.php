<?php namespace SeIT\Queues\EveApi\Account;

use Illuminate\Contracts\Queue\Job;

/**
* Worker Class receives the fire() event and hands over the real API Handling to sub-classes for segmentation of worker
*/

class Worker
{
    /**
     * @param Job $job
     * @return bool
     */
    public static function fire(Job $job)
    {
        \Log::info(__CLASS__ . ': Worker started');
        $job_record = \SeIT\Models\QueueInformation::where('jobID', '=', $job->getJobId())->first();

        if (!$job_record) {
            $job->release(5);
            return false;
        }
        try {
            // Worker Code starts here

            // Update Characters and APIKeyInfo on Account
            APIKeyInfo::update($job_record->keyID, $job_record->vCode);

            // Update Account related informations
            AccountStatus::update($job_record->keyID, $job_record->vCode);

            // If worker is successful
            $job_record->status = 'Done';
            $job_record->save();
            $job->delete();
            return true;
        } catch (\Exception $e) {
            // If worker runs in Exception
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
