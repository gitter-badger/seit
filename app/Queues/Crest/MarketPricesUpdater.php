<?php namespace SeIT\Queues\Crest;

use Illuminate\Contracts\Queue\Job;
use SeIT\Models\QueueInformation;

/**
 * Updates the Data for Market->Prices from Crest
 */
class MarketPricesUpdater extends CrestBase
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
            $job_record->output = 'Starting Market->Prices Update';
            $job_record->save();

            $url = self::getCrestRoot(\Config::get('seit.crest_uselive'))
                ->json(['object'=>true])->marketPrices->href;
            
            $crest_response = self::getCrestUrl($url);
            \DB::beginTransaction();
            
            if ($crest_response->getStatusCode() == 200) {
                $job_record->output = 'Started Market->Prices Update';
                $job_record->save();
                
                $crest_response_body = $crest_response->json(['object'=>true]);

                \Log::info(__CLASS__ . ': Updating data for ' . count($crest_response_body->items) . ' items');

                foreach ($crest_response_body->items as $item) {
                    $job_record->output = 'Started Market->Prices Update - ' . $item->type->id;
                    $job_record->save();
                    $record = \SeIT\Models\CrestMarketPrices::where('typeID', $item->type->id)->first();

                    if (!$record) {
                        $record = new \SeIT\Models\CrestMarketPrices;
                    }
                    $record->typeID = $item->type->id;
                    if (isset($item->adjustedPrice)) {
                        $record->adjustedPrice = $item->adjustedPrice;
                    } else {
                        $record->adjustedPrice = null;
                    }
                    if (isset($item->averagePrice)) {
                        $record->averagePrice = $item->averagePrice;
                    } else {
                        $record->averagePrice = null;
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
            self::ExceptionHandler($e, $job, $job_record);
            return false;
        }
    }
}
