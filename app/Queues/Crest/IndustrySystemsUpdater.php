<?php namespace SeIT\Queues\Crest;

use Illuminate\Contracts\Queue\Job;
use SeIT\Models\QueueInformation;

/**
 * Updates the Data for Industry->Systems from Crest
 */
class IndustrySystemsUpdater extends CrestBase
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

        if (!parent::checkAttempts($job, $job_record)) {
            return false;
        }

        try {
            $job_record->status = 'Working';
            $job_record->output = 'Starting Industry->Systems Update';
            $job_record->save();

            $url = parent::getCrestRoot(\Config::get('seit.crest_uselive'))
                ->json(['object'=>true])->industry->systems->href;
            
            $crest_response = parent::getCrestUrl($url);
            \DB::beginTransaction();
            
            if ($crest_response->getStatusCode() == 200) {
                $job_record->output = 'Started Industry->Systems Update';
                $job_record->save();
                
                $crest_response_body = $crest_response->json(['object'=>true]);

                \Log::info(__CLASS__ . ': Updating data for ' . count($crest_response_body->items) . ' items');

                foreach ($crest_response_body->items as $item) {
                    $record = \SeIT\Models\CrestIndustrySystems::where('solarSystemID', $item->solarSystem->id)->first();

                    if (!$record) {
                        $record = new \SeIT\Models\CrestIndustrySystems;
                    }
                    
                    $record->solarSystemID = $item->solarSystem->id;
                    
                    foreach ($item->systemCostIndices as $indexObj) {
                        switch ($indexObj->activityID) {
                            case 1:
                                $record->manufacturingIndex = (float) $indexObj->costIndex;
                                break;
                            case 3:
                                $record->teResearchIndex = (float) $indexObj->costIndex;
                                break;
                            case 4:
                                $record->meResearchIndex = (float) $indexObj->costIndex;
                                break;
                            case 5:
                                $record->copyIndex = (float) $indexObj->costIndex;
                                break;
                            case 7:
                                $record->reverseIndex = (float) $indexObj->costIndex;
                                break;
                            case 8:
                                $record->inventionIndex = (float) $indexObj->costIndex;
                                break;
                            default:
                                break;
                        }
                    }
                    $record->save();
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
            parent::ExceptionHandler($e, $job, $job_record);
            return false;
        }
    }
}
