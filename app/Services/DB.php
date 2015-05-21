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
     * List all manufacturable Types
     *
     * @return array Typemap of all things that one can produce
     */
    public static function listTypesManufacture()
    {
        $typeMap = null;
        $query = \DB::Table('invTypes')
            ->select('invTypes.typeID', 'invTypes.typeName')
            ->join('industryActivity', 'invTypes.typeID', '=', 'industryActivity.typeID')
            ->where('invTypes.published', 1)
            ->where('industryActivity.activityID', 1)
            ->orderBy('typeName', 'asc')
            ->get();

        foreach ($query as $e) {
            $typeMap[(int)$e->typeID] = $e->typeName;
        }
        return $typeMap;
    }

    /**
     * Get Materials for a given BPC and activity
     *
     * @param $typeID int TypeID of BPC
     * @param $activityID int Kind of Job (Manufacture, Research, etc.)
     * @return array
     */
    public static function getBPCMaterials($typeID, $activityID)
    {
        $materialMap = null;
        $query = \DB::Table('industryActivityMaterials as iam')
            ->select('typeName', 'materialTypeID', 'quantity')
            ->join('invTypes', 'iam.materialTypeID', '=', 'invTypes.typeID')
            ->where('activityID', $activityID)
            ->where('iam.typeid', $typeID)
            ->orderBy('quantity', 'desc')
            ->get();

        foreach ($query as $e) {
            $materialMap[(int)$e->materialTypeID] = (int) $e->quantity;
        }
        return $materialMap;
    }

    /**
     * Get the Product for a given BPC and activity
     *
     * @param $typeID int TypeID of BPC
     * @param $activityID int Kind of Job (Manufacture, Research, etc.)
     * @return object
     */
    public static function getBPCProduct($typeID, $activityID)
    {
        return \DB::Table('industryActivityProducts')
            ->select('productTypeID')
            ->where('typeID', $typeID)
            ->where('activityID', $activityID)
            ->pluck('productTypeID');
    }

    /**
     * Get the Time needed for a given BPC and activity
     *
     * @param $typeID int TypeID of BPC
     * @param $activityID int Kind of Job (Manufacture, Research, etc.)
     * @return object
     */
    public static function getBPCTime($typeID, $activityID)
    {
        return \DB::Table('industryActivity')
            ->select('time')
            ->where('typeID', $typeID)
            ->where('activityID', $activityID)
            ->pluck('time');
    }

    /**
     * Get the minimum Skills for a given BPC and activity
     *
     * @param $typeID int TypeID of BPC
     * @param $activityID int Kind of Job (Manufacture, Research, etc.)
     * @return array
     */
    public static function getBPCSkills($typeID, $activityID)
    {
        $skillMap = null;
        $query = \DB::Table('industryActivitySkills')
            ->select('skillID', 'level')
            ->where('typeID', $typeID)
            ->where('activityID', $activityID)
            ->get();

        foreach ($query as $e) {
            $skillMap[$e->skillID] = $e->level;
        }
        return $skillMap;
    }

    /**
     * Get an array of Prices mapped to corresponding typeIDs
     * @param $materials array Material list
     * @return array TypeID to Price map
     */
    public static function getMaterialPrices(array $materials)
    {
        $priceMap = null;
        $query = \DB::Table('crest_marketprices')
            ->select('typeID', 'adjustedPrice')
            ->whereIn('typeID', $materials)
            ->get();

        foreach ($query as $e) {
            $priceMap[$e->typeID] = $e->adjustedPrice;
        }

        return $priceMap;
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
}
