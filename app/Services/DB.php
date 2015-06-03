<?php namespace SeIT\Services;

/**
 * Interfacing class for DB
 */
class DB
{
    /**
     * Get all Stations for a Solarsystem
     *
     * @param $solarSystemID int ID of the Solarsystem
     * @return array
     */
    public static function getStations($solarSystemID)
    {
        $stationMap = null;
        $query = \DB::Table('staStations')
            ->select('stationID', 'stationName')
            ->where('solarSystemID', $solarSystemID)
            ->orderBy('stationID', 'asc')
            ->get();
        
        foreach ($query as $e) {
            $stationMap[(int)$e->stationID] = $e->stationName;
        }
        return $stationMap;
    }

    /**
     * Get attributes for a given BPC and activity
     *
     * @param $typeID int TypeID of BPC
     * @return mixed attributes of the chosen Type
     */
    public static function getTypeAttributes($typeID)
    {

        return \DB::Table(\DB::Raw('invTypes AS it'))
            ->select(
                'it.groupID',
                'ig.categoryID',
                'it.typeID',
                'it.typeName',
                'it.volume',
                'it.portionSize',
                'it.basePrice',
                'it.marketGroupID',
                'iap.typeID as blueprintTypeID'
            )
            ->join('industryActivityProducts as iap', 'iap.productTypeID', '=', 'it.typeID')
            ->join('invGroups AS ig', 'it.groupID', '=', 'ig.groupID')
            ->where('it.published', 1)
            ->where('iap.activityID', 1)
            ->where('it.typeID', $typeID)
            ->first();
    }

    /**
     * Get attributes for a given Solarsystem
     *
     * @param $solarSystemID int ID of the Solarsystem
     * @return mixed attributes of the chosen Solarsystem
     */
    public static function getSolarSystem($solarSystemID)
    {
        return \DB::Table('mapSolarSystems')
            ->select('regionID', 'constellationID', 'solarSystemID', 'solarSystemName', 'security')
            ->where('solarSystemID', $solarSystemID)
            ->first();
    }

    /**
     * Get TypeID for a TypeName
     *
     * @param string TypeName to lookup
     * @return int TypeID
     */
    public static function getTypeIdByName($typeName)
    {
        return \DB::Table('invTypes')
            ->select('typeID')
            ->where('typeName', $typeName)
            ->pluck('typeID');
    }

    /**
     * Get TypeName for a TypeID
     *
     * @param int TypeID to lookup
     * @return string TypeName
     */
    public static function getTypeNameById($typeID)
    {
        return \DB::Table('invTypes')
            ->select('typeName')
            ->where('typeID', $typeID)
            ->pluck('typeName');
    }
    
    /**
     * Find a Skillevel for a Character
     *
     * @param $characterID int ID of the Character
     * @param $skillTypeID int ID of the Skill
     * @return int Level of the Skill
     */
    public static function getSkillLevel($characterID, $skillTypeID)
    {
        return \DB::Table('eve_character_sheet_skills')
            ->select('level')
            ->where('characterID', '=', $characterID)
            ->where('typeID', '=', $skillTypeID)
            ->pluck('level');
    }

    public static function iterateMarketGroupData($parentID = null)
    {
        $parentNodes = static::getMarketGroupTree($parentID);

        foreach ($parentNodes as $parentNode) {
            if ($parentNode->hasTypes==0) {
                $parentNode->children = static::iterateMarketGroupData($parentNode->id);
            }
        }

        return $parentNodes;
    }

    public static function getMarketGroupTree($parentID = null)
    {
        return \DB::Table('invMarketGroups')
            ->select(
                'invMarketGroups.marketGroupID as id',
                'invMarketGroups.marketGroupName as label',
                'invMarketGroups.hasTypes'
            )
            ->where('invMarketGroups.parentGroupID', $parentID)
            ->orderBy('invMarketGroups.marketGroupName', 'asc')
            ->get();
    }

    public static function getCharacterIDsByUserID($userID)
    {
        return \DB::Table('eve_account_apikeyinfo_characters')
            ->select('eve_account_apikeyinfo_characters.characterID')
            ->join('seit_keys', 'seit_keys.keyID', '=', 'eve_account_apikeyinfo_characters.keyID')
            ->where('seit_keys.user_id', '=', $userID)
            ->groupBy('eve_account_apikeyinfo_characters.characterID')
            ->orderBy('eve_account_apikeyinfo_characters.characterID', 'asc')
            ->lists('characterID');
    }
}
