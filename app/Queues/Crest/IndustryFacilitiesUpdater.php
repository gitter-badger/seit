<?php namespace SeIT\Queues\Crest;

use \Illuminate\Contracts\Queue\Job;
use \SeIT\Models\QueueInformation;

/**
 * Updates the Data for Industry->Facilities from Crest
 */
class IndustryFacilitiesUpdater extends CrestBase
{
    /**
     * @param Job $job
     * @return bool
     */
    public static function fire(Job $job)
    {
        \Log::info(__CLASS__ . ': Worker started');
        // Disable Query-Logging - we do a ton of inserts..
        \DB::connection()->disableQueryLog();

        $job_record = QueueInformation::where('jobID', '=', $job->getJobId())->first();

        if (!$job_record) {
            $job->release(5);
            return false;
        }

        if (!self::checkAttempts($job, $job_record)) {
            return false;
        }

        try {
            $job_record->status = 'Working';
            $job_record->output = 'Starting Industry->Facilities Update';
            $job_record->save();

            $url = self::getCrestRoot(\Config::get('seit.crest_uselive'))
                ->json(['object'=>true])->industry->facilities->href;
            
            $crest_response = self::getCrestUrl($url);
            \DB::beginTransaction();
            
            if ($crest_response->getStatusCode() == 200) {
                $job_record->output = 'Started Industry->Facilities Update';
                $job_record->save();

                $crest_response_body = $crest_response->json(['object'=>true]);

                \Log::info(__CLASS__ . ': Updating data for ' . count($crest_response_body->items) . ' items');

                foreach ($crest_response_body->items as $item) {
                    $record = \SeIT\Models\CrestIndustryFacilities::where('facilityID', $item->facilityID)->first();
                        
                    if (!$record) {
                        $record = new \SeIT\Models\CrestIndustryFacilities;
                    }

                    $record->facilityID = $item->facilityID;
                    $record->stationName = $item->name;
                    $record->ownerID = $item->owner->id;
                    $record->regionID = $item->region->id;
                    $record->solarSystemID = $item->solarSystem->id;
                    $record->stationType = $item->type->id;
                    if (isset($item->tax)) {
                        $record->tax = $item->tax;
                    } else {
                        $record->tax = null;
                    }
                    $record->save();

                    $entity = \SeIT\Models\SeITEntityNamesMap::where('entityID', $item->owner->id)->first();
                    if (!$entity) {
                        $entity = new \SeIT\Models\SeITEntityNamesMap();
                        $entity->entityID = $item->owner->id;
                        $entity->resolved = false;
                        $entity->save();
                    }
                }
                $job_record->status = 'Done';
                $job_record->output = null;
                $job_record->save();
                $job->delete();
                \DB::commit();
                return true;
            } else {
                \Log::info('No Respone from CREST');
                $job_record->status = 'Error';
                $job_record->output = 'Last Status: No proper response from CREST' . PHP_EOL .
                    'Response Code: ' . $crest_response->status_code . PHP_EOL .
                    'Status' . $crest_response->success . PHP_EOL .
                    'URL: ' . $crest_response->url;
                $job_record->save();
                $job->delete();
                \DB::commit();
                return true;
            }

        } catch (\Exception $e) {
            \DB::rollback();
            self::ExceptionHandler($e, $job, $job_record);
            return false;
        }
    }
}
