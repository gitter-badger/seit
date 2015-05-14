<?php namespace SeIT\Services;

use SeIT\Models\QueueInformation;

/**
 * Class Queue
 * @package SeIT\Services
 */
class Queue
{
    /**
     * @param $command
     */
    public static function addCrestJob($command)
    {
        $job = QueueInformation::where('command', $command)
            ->whereIn('status', array('Queued', 'Working'))
            ->first();

        if (!$job) {
            $jobID = \Queue::push($command, array());
            QueueInformation::create(
                array(
                    'jobID' => $jobID,
                    'status' => 'Queued',
                    'command' => $command
                )
            );
        } else {
            \Log::warning(
                'The job was not queued, another one is still in the queue waiting. Details: ' .
                $job,
                array('src' => __CLASS__)
            );
            $jobID = $job->jobID;
        }
        return $jobID;
    }

    /**
     * @param $command
     * @param int $keyID
     * @param string $vCode
     * @param string $api
     * @param string $scope
     */
    public static function addEveApiJob($command, $keyID = 0, $vCode = '', $api = '', $scope = '')
    {
        $job = QueueInformation::where('command', $command)
            ->whereIn('status', array('Queued', 'Working'))
            ->where('api', $api)
            ->where('keyID', $keyID)
            ->first();

        if (!$job) {
            $jobID = \Queue::push($command, array(
                'api' => $api,
                'scope' => $scope,
                'keyID' => $keyID,
                'vCode' => $vCode,
            ));

            QueueInformation::insert(array(
                'jobID' => $jobID,
                'status' => 'Queued',
                'command' => $command,
                'keyID' => $keyID,
                'vCode' => $vCode,
                'api' => $api,
                'scope' => $scope,
            ));

        } else {
            \Log::warning(
                'The job was not queued, another one is still in the queue waiting. Details: ' .
                $job->jobID,
                array('src' => __CLASS__)
            );
            $jobID = $job->jobID;
        }
        return $jobID;
    }
}
