<?php namespace SeIT\Queues\Crest;

use \Exception;
use \GuzzleHttp\Client as GuzzleClient;
use \Illuminate\Contracts\Queue\Job;
use \SeIT\Models\QueueInformation;

/**
 * Class to get Data from a Crest Endpoint
 */
class CrestBase
{
    /**
    * Get the content of the CREST root document
    *
    * @param $live boolean flag to choose from either Tranquility or Singularity
    * @return mixed
    */
    public static function getCrestRoot($live = true)
    {
        if ($live) {
            \Log::debug('Using Tranquility CREST connection for Request.');
            $url = 'http://public-crest.eveonline.com/';
        } else {
            \Log::debug('Using Singularity CREST connection for Request.');
            $url = 'http://public-crest-sisi.testeveonline.com/';
        }
        $client = new GuzzleClient();
        $request = $client->createRequest('GET', $url);
        $userAgent = 'SeIT/SSO-Bridge v.' . \Config::get('seit.version') . ' (Contact '.\Config::get('seit.owner').')';
        $request->setHeader('User-Agent', $userAgent);
        return $client->send($request);
    }

    /**
    *   Gets data from $url
    *   $url should be retrieved via call to getCrestRoot() prior to navigate using CREST supplied href's.
    *
    *   @param $url string URL from CREST to get
    *
    *   @return mixed Result of GET Request to Url
    */
    public static function getCrestUrl($url)
    {
        $client = new GuzzleClient();
        $request = $client->createRequest('GET', $url);
        $userAgent = 'SeIT/SSO-Bridge v.' . \Config::get('seit.version') . ' (Contact '.\Config::get('seit.owner').')';
        $request->setHeader('User-Agent', $userAgent);
        return $client->send($request);
    }

    /**
     * Checks the attempt count
     *
     * Returns false if Job was run once, else true
     *
     * @param $job \Illuminate\Contracts\Queue\Job
     * @param job_record \SeIT\Models\QueueInformation
     * @return bool
     */
    public static function checkAttempts(Job $job, QueueInformation $job_record)
    {
        if ($job->attempts() > 1) {
            $job_record->status = 'Error';
            $job_record->output = 'Too many retries, aborting job';
            $job_record->save();
            $job->delete();
            return false;
        } else {
            return true;
        }
    }

    /**
     * Handles the Exception that may occour in the Crest Workers
     * @param $e \Exception
     * @param $job \Illuminate\Contracts\Queue\Job
     * @param $job_record \SeIT\Models\QueueInformation
     * @return void|mixed
     */
    public static function exceptionHandler(Exception $e, Job $job, QueueInformation $job_record)
    {
        $job_record->status = 'Error';
        $job_record->output = 'Last status: ' . $job_record->output . PHP_EOL .
            'Error: ' . $e->getCode() . ': ' . $e->getMessage() . PHP_EOL .
            'File: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL .
            'Trace: ' . $e->getTraceAsString() . PHP_EOL .
            'Previous: ' . $e->getPrevious();
        $job_record->save();
        $job->delete();
    }
}
