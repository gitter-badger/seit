<?php namespace SeIT\Queues\EveApi\Char;

use \Pheal\Pheal;
use \Pheal\Exceptions\APIException;
use \Pheal\Exceptions\PhealException;
use \SeIT\Services\BaseApi as EveApi;

/**
 * Class Blueprints
 * @package SeIT\Queues\EveApi\Char
 */
class Blueprints
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
        $api = 'Blueprints';

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
                $phealResult = $pheal->charScope->Blueprints(array('characterID' => $characterID));
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
                // Flag a Characters BPs as deleted
                \SeIT\Models\EveCharacterBlueprint::where('characterID', '=', $characterID)->delete();

                foreach ($phealResult->blueprints as $blueprint) {
                    $blueprint_data = \SeIT\Models\EveCharacterBlueprint::withTrashed()
                        ->where('characterID', '=', $characterID)
                        ->where('itemID', '=', $blueprint->itemID)
                        ->where('typeID', '=', $blueprint->typeID)
                        ->first();
                    
                    if (!$blueprint_data) {
                        $blueprint_data = new \SeIT\Models\EveCharacterBlueprint;
                    }
                    
                    $blueprint_data->characterID        = $characterID;
                    $blueprint_data->itemID             = $blueprint->itemID;
                    $blueprint_data->locationID         = $blueprint->locationID;
                    $blueprint_data->typeID             = $blueprint->typeID;
                    $blueprint_data->flagID             = $blueprint->flagID;
                    $blueprint_data->quantity           = $blueprint->quantity;
                    $blueprint_data->timeEfficiency     = $blueprint->timeEfficiency;
                    $blueprint_data->materialEfficiency = $blueprint->materialEfficiency;
                    $blueprint_data->runs               = $blueprint->runs;
                    $blueprint_data->deleted_at         = null;
                    // Save the information
                    $blueprint_data->save();
                }
                
                // Update the cached_until time in the database for this api call
                EveApi::setDbCache($scope, $api, $phealResult->cached_until, $characterID);

            }
        }

        EveApi::unlockCall($lockhash);

        return true;
    }
}
