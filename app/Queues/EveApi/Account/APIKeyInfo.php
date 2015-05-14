<?php namespace SeIT\Queues\EveApi\Account;

use \Pheal\Pheal;
use \Pheal\Exceptions\APIException;
use \Pheal\Exceptions\PhealException;
use \SeIT\Services\BaseApi as EveApi;

/**
 * Class APIKeyInfo
 * @package SeIT\Queues\EveApi\Account
 */
class APIKeyInfo
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
        \Log::info('APIKeyInfo loaded');

        EveApi::bootstrap();
        EveApi::validateKeyPair($keyID, $vCode);

        // Set key scopes and check if the call is banned
        $scope = 'Account';
        $api = 'APIKeyInfo';

        if (EveApi::isBannedCall($api, $scope, $keyID)) {
            return false;
        }

        $pheal = new  Pheal($keyID, $vCode);
        
        try {
            $phealResult = $pheal->accountScope->APIKeyInfo();
        } catch (APIException $e) {
            EveApi::banCall($api, $scope, $keyID, 0, $e->getCode() . ': ' . $e->getMessage());
            return false;
        } catch (PhealException $e) {
            throw $e;
        }

        if (!EveApi::checkDbCache($scope, $api, $phealResult->cached_until, $keyID)) {
            $dbRecord = \SeIT\Models\EveAccountAPIKeyInfo::where('keyID', '=', $keyID)->first();

            if (!$dbRecord) {
                $dbRecord = new \SeIT\Models\EveAccountAPIKeyInfo;
            }

            $dbRecord->keyID = $keyID;
            $dbRecord->accessMask = $phealResult->key->accessMask;
            $dbRecord->type = $phealResult->key->type;
            $dbRecord->expires = (strlen($phealResult->key->expires) > 0 ? $phealResult->key->expires : null);
            $dbRecord->save();

            $knownCharacters = \SeIT\Models\EveAccountAPIKeyInfoCharacters::where('keyID', '=', $keyID)
                ->select('characterID')
                ->lists('characterID');

            \Log::debug('Characters', (array)$knownCharacters);

            foreach ($phealResult->key->characters as $character) {
                // Check if we need to update || insert
                $character_data = \SeIT\Models\EveAccountAPIKeyInfoCharacters::where('keyID', '=', $keyID)
                    ->where('characterID', '=', $character->characterID)
                    ->first();

                // else, add/update
                if (!$character_data) {
                    $character_data = new \SeIT\Models\EveAccountAPIKeyInfoCharacters;
                }
                
                $character_data->keyID = $keyID;
                $character_data->characterID = $character->characterID;
                $character_data->characterName = $character->characterName;
                $character_data->corporationID = $character->corporationID;
                $character_data->corporationName = $character->corporationName;
                $character_data->save();
                
                // Remove this characterID from the known_characters as its still on
                // the key
                if (array_key_exists($character->characterID, $knownCharacters)) {
                    unset($knownCharacters[$character->characterID]);
                }
            }

            EveApi::setDbCache($scope, $api, $phealResult->cached_until, $keyID);
            return true;
        }
        return false;
    }
}
