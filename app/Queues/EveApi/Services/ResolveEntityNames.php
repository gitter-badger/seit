<?php namespace SeIT\Queues\EveApi\Services;

use Illuminate\Contracts\Queue\Job;
use \Pheal\Pheal;
use \SeIT\Services\BaseApi as EveApi;

/**
 * Class ResolveEntityNames
 * @package SeIT\Queues\EveApi\Services
 */
class ResolveEntityNames
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
            \DB::beginTransaction();
            $query = \SeIT\Models\SeITEntityNamesMap::where('resolved', '=', false)
                ->select('entityID')
                ->get();

            if (count($query) > 0) {
                EveApi::bootstrap();
                $pheal = new  Pheal();

                // iterate object to array
                $ids = array();
                foreach ($query as $id) {
                    $ids[] = $id->entityID;
                }

                foreach (array_chunk($ids, 15) as $resolvable) {
                    $names = $pheal->eveScope->CharacterName(array('ids' => implode(',', $resolvable)));

                    foreach ($names->characters as $lookup_result) {
                        $record = \SeIT\Models\SeITEntityNamesMap::where(
                            'entityID',
                            $lookup_result->characterID
                        )
                        ->first();
                        
                        $record->resolved = true;
                        $record->entityName = $lookup_result->name;
                        $record->save();
                    }
                }
            }
            $job_record->status = 'Done';
            $job_record->save();
            $job->delete();
            \DB::commit();
            return true;

        } catch (\Exception $e) {
            \DB::rollback();
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
