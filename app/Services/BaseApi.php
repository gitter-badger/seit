<?php namespace SeIT\Services;

/*
The MIT License (MIT)

Copyright (c) 2014 - 2015 eve-seat

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

use Carbon\Carbon;
use Pheal\Core\Config as PhealConfig;

/**
 * Class BaseApi
 * @package SeIT\Services
 */
class BaseApi
{

    /**
     * Bootstraps Pheal\Pheal
     *
     * @throws SeIT\Exceptions\APIServerDown
     */
    public static function bootstrap()
    {
        $psrlog = new \Monolog\Logger('phealng');
        $psrlog->pushHandler(
            new \Monolog\Handler\StreamHandler(storage_path() . '/logs/phealng.log', \Monolog\Logger::DEBUG)
        );
        
        PhealConfig::getInstance()->cache = new \Pheal\Cache\FileStorage(storage_path(). '/cache/phealcache/');
        PhealConfig::getInstance()->access = new \Pheal\Access\StaticCheck();
        PhealConfig::getInstance()->log = new \Pheal\Log\PsrLogger($psrlog);
        PhealConfig::getInstance()->http_user_agent =
            'SeIT ' . \Config::get('seit.version') . ' API Fetcher for ' . \Config::get('seit.owner');
        
        PhealConfig::getInstance()->api_customkeys = true;
        PhealConfig::getInstance()->http_method = 'curl';

        if (\Cache::get('eve_api_error_count') >= \Config::get('seit.error_limit')) {
            \Cache::set('eve_api_down', true, 30);
            \Cache::decrement('eve_api_error_count', 10);
        }
        // Check if the EVE Api has been detected as 'down'.
        if (\Cache::has('eve_api_down')) {
            throw new \SeIT\Exceptions\APIServerDown;
        }

        \DB::connection()->disableQueryLog();
    }

    /**
     * @param $keyID int API Key ID
     * @param $vCode string Verification Code
     * @throws \Exception
     */
    public static function validateKeyPair($keyID, $vCode)
    {
        if (!is_numeric($keyID)) {
            throw new \Exception('A API keyID must be a integer, we got: ' . $keyID);
        }
        if (strlen($vCode) <> 64) {
            throw new \Exception('A vCode should be 64 chars long, we got: ' . $vCode);
        }
    }

    /**
     * Creates an Hash from given Api Call data
     *
     * @param string $api api that gets called
     * @param string $scope scope of the call
     * @param string $owner owner of the call (keyID or characterID)
     * @return array
     */
    public static function makeCallHash($api, $scope, $owner)
    {
        return md5(implode(',', array($api, $scope, $owner)));
    }
    
    /**
     * Disables Api key
     *
     * @param $keyID integer The key to disable
     * @param $error mixed Reason to disable the key
     * @throws \Exception
     */
    public static function disableKey($keyID, $error = null)
    {
        $key = \SeIT\Models\SeITKey::where('keyID', '=', $keyID)->first();
        if (!$key) {
            throw new \Exception('Unable to find the entry in `seit_keys` to disable key: ' . $keyID);
        }
        $key->isOk = 0;
        $key->lastError = $error;
        $key->save();
    }

    /**
     * @param $api
     * @param $scope
     * @param int $owner
     * @param int $accessMask
     * @param null $reason
     */
    public static function banCall($api, $scope, $owner = 0, $accessMask = 0, $reason = null)
    {
        \Log::warning(
            'Processing a ban request for api: ' . $api . ' scope: ' . $scope . ' owner: ' . $owner,
            array('src' => __CLASS__)
        );
        // Check if we should retreive the current access mask
        if ($accessMask == 0) {
            $accessMask = \SeIT\Models\EveAccountAPIKeyInfo::where('keyID', '=', $owner)->pluck('accessMask');
        }
        // Generate a hash with which to ID this call
        $hash = self::makeCallHash($api, $scope, $owner . $accessMask);
        // Check the cache if a ban has been recorded
        if (!\Cache::has('call_ban_grace_count_' . $hash)) {
            // Record the new ban, getting the grance period from the seit config and return
            \Cache::put('call_ban_grace_count_' . $hash, 0, \Config::get('seit.ban_grace'));
            return;
        } else {
            // Check if we have reached the limit for the allowed bad calls from the config
            if (\Cache::get('call_ban_grace_count_' . $hash) < \Config::get('seit.ban_limit') - 1) {
                // Add another one to the amount of failed calls and return
                \Cache::increment('call_ban_grace_count_' . $hash);
                return;
            }
        }
        \Log::warning(
            'Ban limit reached. Actioning ban for api: ' . $api . ' scope: ' . $scope . ' owner: ' . $owner,
            array('src' => __CLASS__)
        );
        // We _should_ only get here once the ban limit has been reached
        $banned = \SeIT\Models\BannedCall::where('hash', '=', $hash)->first();
        if (!$banned) {
            $banned = new \SeIT\Models\BannedCall;
        }
        $banned->ownerID = $owner;
        $banned->api = $api;
        $banned->scope = $scope;
        $banned->accessMask = $accessMask;
        $banned->hash = $hash;
        $banned->reason = $reason;
        $banned->save();
        // We also need to keep in mind how many errors have occured so far.
        // This is mainly for the checks that are done in bootstrap()
        // allowing us to pause and not cause a IP to be banned.
        if (\Cache::has('eve_api_error_count')) {
            \Cache::increment('eve_api_error_count');
        } else {
            \Cache::put('eve_api_error_count', 1, 30);
        }
    }

    /**
     * @param $api
     * @param $scope
     * @param int $owner
     * @param int $accessMask
     * @return bool
     */
    public static function isBannedCall($api, $scope, $owner = 0, $accessMask = 0)
    {
        // Check if we should retreive the current access mask
        if ($accessMask == 0) {
            $accessMask = \SeIT\Models\EveAccountAPIKeyInfo::where('keyID', '=', $owner)->pluck('accessMask');
        }
        $hash = self::makeCallHash($api, $scope, $owner . $accessMask);
        $banned = \SeIT\Models\BannedCall::where('hash', '=', $hash)->first();
        if ($banned) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $api
     * @param $scope
     * @param $cachedUntil
     * @param int $owner
     * @return bool
     */
    public static function checkDbCache($api, $scope, $cachedUntil, $owner = 0)
    {
        // Generate the hash based on the func args
        $hash = self::makeCallHash($api, $scope, $owner);
        $current_cache_time = \SeIT\Models\CachedUntil::where('hash', '=', $hash)->first();
        // Check if we have a cache timer set.
        if ($current_cache_time) {
            // If the timer is still the same as when we set it, return true
            // Else, return false indicating its no longer up to date.
            if ($current_cache_time->cached_until == $cachedUntil) {
                return true;
            } else {
                return false;
            }
        } else {
            // No cache timer means its not up to date and needs updatin
            return false;
        }
    }

    /**
     * @param $api
     * @param $scope
     * @param $cachedUntil
     * @param int $owner
     */
    public static function setDbCache($api, $scope, $cachedUntil, $owner = 0)
    {
        // Generate the hash based on the func args
        $hash = self::makeCallHash($api, $scope, $owner);
        $current_cache_time = \SeIT\Models\CachedUntil::where('hash', '=', $hash)->first();
        if ($current_cache_time) {
            $current_cache_time->cached_until = $cachedUntil;
            $current_cache_time->save();
        } else {
            \SeIT\Models\CachedUntil::create(array(
                'ownerID' => $owner,
                'api' => $api,
                'scope' => $scope,
                'hash' => $hash,
                'cached_until' => $cachedUntil
            ));
        }
    }

    /**
     * @param $api
     * @param $scope
     * @param int $owner
     * @return array
     */
    public static function lockCall($api, $scope, $owner = 0)
    {
        // Generate the hash based on the func args
        $hash = self::makeCallHash($api, $scope, $owner);
        \Cache::put('api_lock_' . $hash, '_locked_', Carbon::now()->addMinutes(60));
        return $hash;
    }

    /**
     * @param $api
     * @param $scope
     * @param int $owner
     * @return bool
     */
    public static function isLockedCall($api, $scope, $owner = 0)
    {
        // Generate the hash based on the func args
        $hash = self::makeCallHash($api, $scope, $owner);
        if (\Cache::has('api_lock_' . $hash)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $hash
     */
    public static function unlockCall($hash)
    {
        \Cache::forget('api_lock_' . $hash);
    }

    /**
     * @param $keyID
     * @return array
     * @throws \Exception
     * @throws \Pheal\Exceptions\PhealException
     */
    public static function determineAccess($keyID)
    {
        // Locate the key in the db
        $key = \SeIT\Models\SeITKey::where('keyID', '=', $keyID)->where('isOk', '=', 1)->first();
        if (!$key) {
            return array();
        }
        
        // Attempt to get the type & accessMask from the database.
        \SeIT\Queues\BaseApi\Account\APIKeyInfo::update($keyID, $key->vCode);
        
        $key_mask_info = \SeIT\Models\EveAccountAPIKeyInfo::where('keyID', '=', $keyID)->first();
        
        \SeIT\Queues\BaseApi\Account\AccountStatus::update($keyID, $key->vCode);
        
        // If we still can't determine mask information, leave everything
        if (!$key_mask_info) {
            return array();
        }
        // Prepare a return by setting the 'type' key to the key type we have
        $type = ($key_mask_info->type == 'Account') ? 'Character' : $key_mask_info->type;
        $return_access = array('type' => $type);
        // Loop over all the masks we have, and return those we have access to for this key
        foreach (\SeIT\Models\BaseApiCalllist::where('type', '=', $type)->get() as $mask) {
            if ($key_mask_info->accessMask & $mask->accessMask) {
                $return_access['access'][] = array('type' => $mask->type, 'name' => $mask->name);
            }
        }
        // Return it all as a nice array
        return $return_access;
    }

    /**
     * @param $keyID
     * @return array|bool
     */
    public static function findKeyCharacters($keyID)
    {
        // Locate the key in the db
        $characters = \SeIT\Models\EveAccountAPIKeyInfoCharacters::where('keyID', '=', $keyID)->first();
        if (!$characters) {
            return false;
        }
        $return = array();
        foreach (\SeIT\Models\EveAccountAPIKeyInfoCharacters::where('keyID', '=', $keyID)->get() as $character) {
            $return[] = $character->characterID;
        }
        // Return it all as a nice array
        return $return;
    }

    /**
     * @param $keyID
     * @return array|bool
     */
    public static function findKeyCharactersFull($keyID)
    {
        // Locate the key in the db
        $characters = \SeIT\Models\EveAccountAPIKeyInfoCharacters::where('keyID', '=', $keyID)->first();
        if (!$characters) {
            return false;
        }
        $return = array();
        foreach (\SeIT\Models\EveAccountAPIKeyInfoCharacters::where('keyID', '=', $keyID)->get() as $character) {
            $return[] = array('characterID' => $character->characterID, 'characterName' => $character->characterName);
        }
        // Return it all as a nice array
        return $return;
    }

    /**
     * @param $characterID
     * @return bool
     */
    public static function findCharacterCorporation($characterID)
    {
        // Locate the key in the db
        $character = \SeIT\Models\EveAccountAPIKeyInfoCharacters::where('characterID', '=', $characterID)->first();
        if (!$character) {
            return false;
        }
        // Return the characters corporationID
        return $character->corporationID;
    }
}
