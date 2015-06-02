<?php namespace SeIT\Queues\EveApi\Char;

use \Pheal\Pheal;
use \Pheal\Exceptions\APIException;
use \Pheal\Exceptions\PhealException;
use \SeIT\Services\BaseApi as EveApi;

/**
 * Class IndustryJobs
 * @package SeIT\Queues\EveApi\Char
 */
class IndustryJobs
{
    /**
     * @param $keyID
     * @param $vCode
     * @return bool
     * @throws PhealException
     * @throws \Exception
     * @throws \SeIT\Exceptions\APIServerDown
     */
    public static function update($keyID, $vCode)
    {
        EveApi::bootstrap();
        EveApi::validateKeyPair($keyID, $vCode);

        // Set key scopes and check if the call is banned
        $scope = 'Char';
        $api = 'IndustryJobs';

        if (EveApi::isBannedCall($api, $scope, $keyID)) {
            return false;
        }

        // Get the characters for this key
        $characters = EveApi::findKeyCharacters($keyID);

        // Check if this key has any characters associated with it
        if (!$characters) {
            return false;
        }

        // Lock the call so that we are the only instance of this running now()
        // If it is already locked, just return without doing anything
        if (!EveApi::isLockedCall($api, $scope, $keyID)) {
            $lockhash = EveApi::lockCall($api, $scope, $keyID);
        } else {
            return false;
        }

        foreach ($characters as $characterID) {
            $pheal = new  Pheal($keyID, $vCode);
            
            try {
                $phealResult = $pheal->charScope->IndustryJobs(array('characterID' => $characterID));
            } catch (APIException $e) {
                EveApi::banCall($api, $scope, $keyID, 0, $e->getCode() . ': ' . $e->getMessage());
                EveApi::unlockCall($lockhash);
                return false;
            } catch (PhealException $e) {
                EveApi::unlockCall($lockhash);
                throw $e;
            }

            // Check if the data in the database is still considered up to date.
            // checkDbCache will return true if this is the case
            if (!EveApi::checkDbCache($scope, $api, $phealResult->cached_until, $characterID)) {
                // Flag all current Jobs as deleted
                \SeIT\Models\EveCharacterIndustryJobs::where('installerID', '=', $characterID)->delete();
                // Save each new or restore deleted
                foreach ($phealResult->jobs as $job) {
                    $job_data = \SeIT\Models\EveCharacterIndustryJobs::withTrashed()
                        ->where('jobID', '=', $job->jobID)
                        ->where('installerID', '=', $job->installerID)
                        ->first();
                    
                    if (!$job_data) {
                        $job_data = new \SeIT\Models\EveCharacterIndustryJobs;
                    }

                    
                    $job_data->jobID                = $job->jobID;
                    $job_data->installerID          = $job->installerID;
                    $job_data->installerName        = $job->installerName;
                    $job_data->facilityID           = $job->facilityID;
                    $job_data->solarSystemID        = $job->solarSystemID;
                    $job_data->solarSystemName      = $job->solarSystemName;
                    $job_data->stationID            = $job->stationID;
                    $job_data->activityID           = $job->activityID;
                    $job_data->blueprintID          = $job->blueprintID;
                    $job_data->blueprintTypeID      = $job->blueprintTypeID;
                    $job_data->blueprintTypeName    = $job->blueprintTypeName;
                    $job_data->blueprintLocationID  = $job->blueprintLocationID;
                    $job_data->outputLocationID     = $job->outputLocationID;
                    $job_data->runs                 = $job->runs;
                    $job_data->cost                 = $job->cost;
                    $job_data->teamID               = $job->teamID;
                    $job_data->licensedRuns         = $job->licensedRuns;
                    $job_data->probability          = $job->probability;
                    $job_data->productTypeID        = $job->productTypeID;
                    $job_data->productTypeName      = $job->productTypeName;
                    $job_data->status               = $job->status;
                    $job_data->timeInSeconds        = $job->timeInSeconds;
                    $job_data->startDate            = $job->startDate;
                    $job_data->endDate              = $job->endDate;
                    $job_data->pauseDate            = $job->pauseDate;
                    $job_data->completedDate        = $job->completedDate;
                    $job_data->completedCharacterID = $job->completedCharacterID;
                    $job_data->successfulRuns       = $job->successfulRuns;
                    $job_data->deleted_at           = null;
                    // Save the information
                    $job_data->save();
                }
                
                // Update the cached_until time in the database for this api call
                EveApi::setDbCache($scope, $api, $phealResult->cached_until, $characterID);

            }
        }

        EveApi::unlockCall($lockhash);

        return true;
    }
}
