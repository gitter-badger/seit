<?php namespace SeIT\Services;

/**
 * Helper Class for various, yet distinct Tasks
 */
class Helper
{
    /*
    * Strips the Namespace of a Classname
    * 
    * @param $classname string Classname with full Namespace
    * @return string Classname without Namespace
    * @access public
    * @static
    */
    /**
     * @param $classname
     * @return mixed
     */
    public static function stripNamespaceFromClassname($classname)
    {
        if (preg_match('@([\w]+)$@', $classname, $matches)) {
            $classname = $matches[0];
        }
        
        return $classname;
    }

    /**
     * Resolves EntityIDs to EntityNames
     *
     * @param $lookupId int ID to Lookup in Cache and DB
     * @return string EntityName
     */
    public static function resolveIdToName($lookupId)
    {
        $key = 'nameid_' . $lookupId;

        if (\Cache::has($key)) {
            return \Cache::get($key);
        }

        $entityName = \DB::Table('seit_entity_names_map')
            ->where('entityID', $lookupId)
            ->where('resolved', true)
            ->select('entityName')
            ->pluck('entityName');

        \Cache::forever($key, $entityName);

        return $entityName;
    }
}
