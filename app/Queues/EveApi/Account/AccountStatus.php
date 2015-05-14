<?php namespace SeIT\Queues\EveApi\Account;

use \Pheal\Pheal;
use \Pheal\Exceptions\APIException;
use \Pheal\Exceptions\PhealException;
use \SeIT\Services\BaseApi as EveApi;

/**
 * Class AccountStatus
 * @package SeIT\Queues\EveApi\Account
 */
class AccountStatus
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
        $scope = 'Account';
        $api = 'AccountStatus';

        if (EveApi::isBannedCall($api, $scope, $keyID)) {
            return false;
        }

        $pheal = new  Pheal($keyID, $vCode);

        try {
            $phealResult = $pheal->accountScope->AccountStatus();
        } catch (APIException $e) {
            EveApi::banCall($api, $scope, $keyID, 0, $e->getCode() . ': ' . $e->getMessage());
            return false;
        } catch (PhealException $e) {
            throw $e;
        }

        if (!EveApi::checkDbCache($scope, $api, $phealResult->cached_until, $keyID)) {
            $dbRecord = \SeIT\Models\EveAccountAccountStatus::where('keyID', '=', $keyID)->first();
            
            if (!$dbRecord) {
                $dbRecord = new \SeIT\Models\EveAccountAccountStatus;
            }

            $dbRecord->keyID = $keyID;
            $dbRecord->paidUntil = $phealResult->paidUntil;
            $dbRecord->createDate = $phealResult->createDate;
            $dbRecord->logonCount = $phealResult->logonCount;
            $dbRecord->logonMinutes = $phealResult->logonMinutes;
            $dbRecord->save();

            // Update the cached_until time in the database for this api call
            EveApi::setDbCache($scope, $api, $phealResult->cached_until, $keyID);
        }
        return true;
    }
}
