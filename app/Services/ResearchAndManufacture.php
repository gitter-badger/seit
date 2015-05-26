<?php namespace SeIT\Services;

/**
 * @class Contains Functions for Research and Manufacture related tasks
 */

class ResearchAndManufacture
{
    const MANUFACTURE = 1;
    const RESEARCH_TE = 3;
    const RESEARCH_ME = 4;
    const COPY = 5;
    const REVERSE = 7;
    const INVENTION = 8;

    /**
     * Resolves EntityIDs to EntityNames
     *
     * @param $lookupId int ID to Lookup in Cache and DB
     * @return string EntityName
     */
    protected static function getBaseJobCost($typeID)
    {
        $totals = 0;
        // Retrieve a Material list
        $materials = static::getBPCMaterials($typeID, 1);
        // Get Prices for Materials (by the Array keys)
        $prices = static::getMaterialPrices(array_keys($materials));

        if (count($materials) != count($prices)) {
            return false;
        }

        foreach ($materials as $material => $count) {
            $totals = $totals + ($count * $prices[$material]);
        }

        return $totals;
    }

    protected static function getBaseJobTime($typeID, $activityID)
    {
        return \DB::Table('industryActivity')
            ->where('typeID', '=', $typeID)
            ->where('activityID', $activityID)
            ->pluck('time');
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
    private static function getBaseTime($typeID, $activityID)
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

    private static function getResearchLabModifier($labType)
    {
        switch ($labType) {
            // Research Lab
            case 1:
                return 0.7;
            // Hyasoda Lab
            case 2:
                return 0.65;
            // Station
            case 0:
            default:
                return 1;
        }
    }

    public static function getLevelModifier($start, $stop, $activityID)
    {
        // at TE Research the Levels are a multiple of 2
        if ($activityID == ResearchAndManufacture::RESEARCH_TE) {
            $start = $start / 2;
            $stop = $stop / 2;
        }

        $level = array(
            0 => 0,
            1 => 105,
            2 => 250,
            3 => 595,
            4 => 1414,
            5 => 3360,
            6 => 8000,
            7 => 19000,
            8 => 45255,
            9 => 107700,
            10 => 256000,
        );
        
        return $level[$stop] - $level[$start];
    }

    public static function getSkillModifier($characterID, $activityID)
    {
        switch ($activityID) {
            case ResearchAndManufacture::MANUFACTURE:
                return (1.0 - 0.05 * DB::getSkillLevel($characterID, 3380)) * (1.0 - 0.03 * DB::getSkillLevel($characterID, 3388));
            case ResearchAndManufacture::RESEARCH_TE:
                return (1.0 - 0.05 * DB::getSkillLevel($characterID, 3403)) * (1.0 - 0.03 * DB::getSkillLevel($characterID, 3388));
            case ResearchAndManufacture::RESEARCH_ME:
                return (1.0 - 0.05 * DB::getSkillLevel($characterID, 3409)) * (1.0 - 0.03 * DB::getSkillLevel($characterID, 3388));
            case ResearchAndManufacture::COPY:
                return (1.0 - 0.05 * DB::getSkillLevel($characterID, 3402)) * (1.0 - 0.03 * DB::getSkillLevel($characterID, 3388));
            case ResearchAndManufacture::REVERSE:
                return 1;
            case ResearchAndManufacture::INVENTION:
                return (1.0 - 0.03 * DB::getSkillLevel($characterID, 3388));
            case defult:
                return 1;
        }
    }

    private static function getSystemCostIndex($system, $activityID)
    {
        switch ($activityID) {
            case ResearchAndManufacture::MANUFACTURE:
                $index_column ="manufacturingIndex";
                break;
            case ResearchAndManufacture::RESEARCH_TE:
                $index_column = "teResearchIndex";
                break;
            case ResearchAndManufacture::RESEARCH_ME:
                $index_column = "meResearchIndex";
                break;
            case ResearchAndManufacture::COPY:
                $index_column ="copyIndex";
                break;
            case ResearchAndManufacture::REVERSE:
                $index_column ="reverseIndex";
                break;
            case ResearchAndManufacture::INVENTION:
                $index_column ="inventionIndex";
                break;
        }
        
        return \DB::Table('crest_industry_systems')->where('solarSystemID', '=', $system)->pluck($index_column);
    }

    public static function getJobFeeResearch($typeID, $activityID, $system, $characterID, $start, $end)
    {
        return ResearchAndManufacture::getBaseJobCost($typeID)
            * ResearchAndManufacture::getSystemCostIndex($system, $activityID)
            * 0.02
            * ResearchAndManufacture::getLevelModifier($start, $end, $activityID)
            / 105;
    }

    public static function getJobFeeManufacture($typeID, $system, $runs)
    {
        return ResearchAndManufacture::getBaseJobCost($typeID)
            * ResearchAndManufacture::getSystemCostIndex($system, ResearchAndManufacture::MANUFACTURE)
            * $runs;

    }

    public static function getJobTimeResearch($typeID, $activityID, $system, $characterID, $start, $end, $labType)
    {
        return ResearchAndManufacture::getBaseJobTime($typeID, $activityID)
            * ResearchAndManufacture::getLevelModifier($start, $end, $activityID)
            * ResearchAndManufacture::getResearchLabModifier($labType)
            * ResearchAndManufacture::getSkillModifier($characterID, $activityID)
            / 105;
    }

    public static function getJobTimeManufacture($typeID, $runs, $te, $characterID, $assemblyType)
    {
        $assemblyModifier = 1;

        switch($assemblyType) {
            // Rapid Assembly
            case 3:
                $assemblyModifier = 0.65;
                break;
            // Thukker Component Assembly
            case 2:
            // Normal POS Assembly
            case 1:
                $assemblyModifier = 0.75;
                break;
            // Station
            case 0:
            default:
                $assemblyModifier = 1;
                break;
        }
        
        return ResearchAndManufacture::getBaseTime($typeID, ResearchAndManufacture::MANUFACTURE)
            * (1.0 - $te / 100)
            * $assemblyModifier
            * ResearchAndManufacture::getSkillModifier($characterID, ResearchAndManufacture::MANUFACTURE)
            * $runs;
    }

    public static function getMaterialsManufacture($typeID, $runs, $me, $characterID, $assemblyType)
    {
        $materials_required = null;
        $assemblyModifier = 1;

        switch($assemblyType) {
            // Rapid Assembly
            case 3:
                $assemblyModifier = 1.05;
                break;
            // Thukker Component Assembly
            case 2:
                $assemblyModifier = 0.85;
                break;
            // Normal POS Assembly
            case 1:
                $assemblyModifier = 0.98;
                break;
            // Station
            case 0:
            default:
                $assemblyModifier = 1;
                break;
        }

        foreach (ResearchAndManufacture::getBPCMaterials($typeID, ResearchAndManufacture::MANUFACTURE) as $material => $quantity) {
            $materials_required[$material] = 
                max(array($runs*ceil(round(($quantity*(1-($me/100)) * $assemblyModifier), 2))));
        }

        return $materials_required;
    }
}
