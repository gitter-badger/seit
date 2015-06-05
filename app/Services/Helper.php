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

    public static function formatTimeInterval(\DateInterval $di)
    {
        $doPlural = function ($nb, $str) {
            return $nb > 1 ? $str . 's' : $str;
        };

        $format = array();

        if ($di->y !== 0) {
            $format[] = "%y ".$doPlural($di->y, "year");
        }
        if ($di->m !== 0) {
            $format[] = "%m ".$doPlural($di->m, "month");
        }
        if ($di->d !== 0) {
            $format[] = "%d ".$doPlural($di->d, "day");
        }
        if ($di->h !== 0) {
            $format[] = "%h ".$doPlural($di->h, "hour");
        }
        if ($di->i !== 0) {
            $format[] = "%i ".$doPlural($di->i, "minute");
        }
        if ($di->s !== 0) {
            $format[] = "%s ".$doPlural($di->s, "second");
        }
        $format = trim(implode(" ", $format));

        return $di->format($format);
    }

    public static function getImageByID($id, $size)
    {
        $baseUrl = '//image.eveonline.com/';

        if ($id > 90000000 && $id < 98000000) {
            return $baseUrl.'Character/'.$id.'_'.$size.'.jpg';
        } elseif (($id > 98000000 && $id < 99000000) || ($id > 1000000 && $id < 2000000)) {
            return $baseUrl.'Corporation/'.$id.'_'.$size.'.png';
        } elseif (($id > 99000000 && $id < 100000000) || ($id > 500000 && $id < 1000000)) {
            return $baseUrl.'Alliance/'.$id.'_'.$size.'.png';
        } elseif (($id > 0 && $id < 500000)) {
            return $baseUrl.'Type/'.$id.'_'.$size.'.png';
        }
        // return path to "Type not found" icon if not matching
        return $baseUrl . 'Type/1_'.$size.'.png';
    }
}
