<?php namespace SeIT\Queues\EveApi\Char;

use \Pheal\Pheal;
use \Pheal\Exceptions\APIException;
use \Pheal\Exceptions\PhealException;
use \SeIT\Services\BaseApi as EveApi;

/**
 * Class CharacterSheet
 * @package SeIT\Queues\EveApi\Char
 */
class CharacterSheet
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
        $api = 'CharacterSheet';

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
                $character_sheet = $pheal->charScope->CharacterSheet(array('characterID' => $characterID));
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
            if (!EveApi::checkDbCache($scope, $api, $character_sheet->cached_until, $characterID)) {
                $character_data = \SeIT\Models\EveCharacterCharacterSheet::where('characterID', '=', $characterID)->first();
                
                if (!$character_data) {
                    $character_data = new \SeIT\Models\EveCharacterCharacterSheet;
                }
                
                $character_data->characterID = $character_sheet->characterID;
                $character_data->name = $character_sheet->name;
                $character_data->DoB = $character_sheet->DoB;
                $character_data->race = $character_sheet->race;
                $character_data->bloodLine = $character_sheet->bloodLine;
                $character_data->ancestry = $character_sheet->ancestry;
                $character_data->gender = $character_sheet->gender;
                $character_data->corporationName = $character_sheet->corporationName;
                $character_data->corporationID = $character_sheet->corporationID;
                $character_data->balance = $character_sheet->balance;
                $character_data->intelligence = $character_sheet->attributes->intelligence;
                $character_data->memory = $character_sheet->attributes->memory;
                $character_data->charisma = $character_sheet->attributes->charisma;
                $character_data->perception = $character_sheet->attributes->perception;
                $character_data->willpower = $character_sheet->attributes->willpower;
                // New stuff from Phoebe
                $character_data->homeStationID = $character_sheet->homeStationID;
                $character_data->factionName = $character_sheet->factionName;
                $character_data->factionID = $character_sheet->factionID;
                $character_data->freeRespecs = $character_sheet->freeRespecs;
                $character_data->cloneJumpDate = $character_sheet->cloneJumpDate;
                $character_data->lastRespecDate = $character_sheet->lastRespecDate;
                $character_data->lastTimedRespec = $character_sheet->lastTimedRespec;
                $character_data->remoteStationDate = $character_sheet->remoteStationDate;
                $character_data->jumpActivation = $character_sheet->jumpActivation;
                $character_data->jumpFatigue = $character_sheet->jumpFatigue;
                $character_data->jumpLastUpdate = $character_sheet->jumpLastUpdate;
                // Save the information
                $character_data->save();
                // Update the characters skills
                foreach ($character_sheet->skills as $skill) {
                    $skill_data = \SeIT\Models\EveCharacterCharacterSheetSkills::where('characterID', '=', $characterID)
                        ->where('typeID', '=', $skill->typeID)
                        ->first();
                    if (!$skill_data) {
                        $skill_data = new \SeIT\Models\EveCharacterCharacterSheetSkills;
                    }
                    $skill_data->characterID = $characterID;
                    $skill_data->typeID = $skill->typeID;
                    $skill_data->skillpoints = $skill->skillpoints;
                    $skill_data->level = $skill->level;
                    $skill_data->published = $skill->published;
                    $skill_data->save();
                }
                // Update the Jump Clones.
                // First thing we need to do is clear out all of the  known clones for
                // this character. We cant really say that clones will remain, so to
                // be safe, clear all of the clones, and populate the new ones.
                // So, lets get to the deletion part. We need to keep in mind that a characterID
                // my have multiple jumpClones. Each clone in turn may have multiple implants
                // which in turn are linked back to a jumpClone and then to a chacterID
                \SeIT\Models\EveCharacterCharacterSheetJumpClones::where('characterID', $characterID)->delete();
                \SeIT\Models\EveCharacterCharacterSheetJumpCloneImplants::where('characterID', $characterID)->delete();
                // Next, loop over the clones we got in the API response
                foreach ($character_sheet->jumpClones as $jump_clone) {
                    $clone_data = new \SeIT\Models\EveCharacterCharacterSheetJumpClones;
                    $clone_data->jumpCloneID = $jump_clone->jumpCloneID;
                    $clone_data->characterID = $characterID;
                    $clone_data->typeID = $jump_clone->typeID;
                    $clone_data->locationID = $jump_clone->locationID;
                    $clone_data->cloneName = $jump_clone->cloneName;
                    $clone_data->save();
                }
                // With the jump clones populated, we move on to the implants per
                // jump clone.
                foreach ($character_sheet->jumpCloneImplants as $jump_clone_implants) {
                    $implant_data = new \SeIT\Models\EveCharacterCharacterSheetJumpCloneImplants;
                    $implant_data->jumpCloneID = $jump_clone_implants->jumpCloneID;
                    $implant_data->characterID = $characterID;
                    $implant_data->typeID = $jump_clone_implants->typeID;
                    $implant_data->typeName = $jump_clone_implants->typeName;
                    $implant_data->save();
                }
                // Finally, we update the character with the implants that they have.
                // Again, we can not assume that the implants they had in the
                // previous update is the same as the current, so, delete
                // everything and populate again.
                \SeIT\Models\EveCharacterCharacterSheetImplants::where('characterID', $characterID)->delete();
                // Now, loop over the implants from the API response and populate them.
                foreach ($character_sheet->implants as $implant) {
                    $implant_data = new \SeIT\Models\EveCharacterCharacterSheetImplants;
                    $implant_data->characterID = $characterID;
                    $implant_data->typeID = $implant->typeID;
                    $implant_data->typeName = $implant->typeName;
                    $implant_data->save();
                }
                // Update the cached_until time in the database for this api call
                EveApi::setDbCache($scope, $api, $character_sheet->cached_until, $characterID);

            }
        }

        EveApi::unlockCall($lockhash);

        return true;
    }
}
