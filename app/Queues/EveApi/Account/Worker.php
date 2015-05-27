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
        $jobRecord = \SeIT\Models\QueueInformation::where('jobID', '=', $job->getJobId())->first();

        if (!$jobRecord) {
            $job->release(5);
            return false;
        }
        try {
            // Update Characters and APIKeyInfo on Account
            APIKeyInfo::update($jobRecord->keyID, $jobRecord->vCode);

            // Update Account related informations
            AccountStatus::update($jobRecord->keyID, $jobRecord->vCode);

            // If worker is successful
            $jobRecord->status = 'Done';
            $jobRecord->save();
            $job->delete();
            return true;
        } catch (\Exception $e) {
            // If worker runs in Exception
            $jobRecord->status = 'Error';
            $jobRecord->output = 'Last status: ' . $jobRecord->output . PHP_EOL .
                'Error: ' . $e->getCode() . ': ' . $e->getMessage() . PHP_EOL .
                'File: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL .
                'Trace: ' . $e->getTraceAsString() . PHP_EOL .
                'Previous: ' . $e->getPrevious();
            $jobRecord->save();
            $job->delete();
            return false;
        }
    }
}
