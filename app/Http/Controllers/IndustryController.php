<?php namespace SeIT\Http\Controllers;

/**
 * Class IndustryController
 * @package SeIT\Http\Controllers
 */
class IndustryController extends Controller
{
    /**
     * @param array $parameters
     * @return \Illuminate\Http\RedirectResponse
     */
    public function missingMethod($parameters = array())
    {
        return redirect()->action('DashboardController@getIndex');
    }

    /**
     * @return \View|mixed returns UI with buildable Types and Systems
     */
    public function getManufacture()
    {
        $characters = \DB::Table('eve_account_apikeyinfo_characters')
            ->join('seit_keys', 'seit_keys.keyID', '=', 'eve_account_apikeyinfo_characters.keyID')
            ->select('characterID', 'characterName')
            ->where('seit_keys.user_id', '=', \Auth::user()->id)
            ->orderBy('characterName')
            ->lists('characterName', 'characterID');
        
        return \View::make('ram.manufacture.view')
            ->with('characters', $characters);
    }

    /***
     * @return \View|mixed returns calculation of Materials and Production Time
     */
    public function postManufacture()
    {
        $errors = array();

        $activityID = 1;
        $payload    = null;
        $me         = \Input::get('me', null);
        $te         = \Input::get('te', null);
        $qty        = \Input::get('qty', null);
        $type       = \Input::get('type', null);
        $system     = \Input::get('system', null);
        $assembly   = \Input::get('assembly', null);
        $character  = \Input::get('character', null);
        
        if ($type === null || $type == 0) {
            $errors[] = "No Type Selected.";
        }

        if ($system === null || $system == 0) {
            $errors[] = "No System selected.";
        }

        if ($qty === null || $qty <= 0) {
            $errors[] = "You can not build something with 0 runs.";
        }
        
        if ($character  === null || $character == 0) {
            $errors[] ="Please select a Character for manufacture.";
        }

        if (count($errors) > 0) {
            return redirect()->back()->with('errors', $errors)->withInput();
        }

        $payload['characters'] = \DB::Table('eve_account_apikeyinfo_characters')
            ->join('seit_keys', 'seit_keys.keyID', '=', 'eve_account_apikeyinfo_characters.keyID')
            ->select('characterID', 'characterName')
            ->where('seit_keys.user_id', '=', \Auth::user()->id)
            ->orderBy('characterName')
            ->lists('characterName', 'characterID');

        $time      = \SeIT\Services\DB::getBPCTime($type, $activityID) * $qty;
        $BPCskills    = \SeIT\Services\DB::getBPCSkills($type, $activityID);
        $baseTypeID    = \SeIT\Services\DB::getBPCProduct($type, $activityID);
        $BPCmaterials = \SeIT\Services\DB::getBPCMaterials($type, $activityID);
        
        // Get Materials
        $materials_required = null;
        foreach ($BPCmaterials as $material => $quantity) {
            $materials_required[$material] =
                max(array($qty*ceil(round(($quantity*(1-($me/100))*(1-(0/100))*(1-(0/100))*(1-(0/100))), 2))));
        }
        
        switch($assembly) {
            case 3:
                $time_modifier_ram = 0.65;
                break;
            case 2:
                $time_modifier_ram = 0.75;
                break;
            case 1:
                $time_modifier_ram = 0.75;
                break;
            case 0:
            default:
                $time_modifier_ram = 1;
                break;
        }

        $time = $time * (1-($te/100)) * $time_modifier_ram;
             
        $payload['input']              = \Input::all();
        $payload['type']               = $type;
        $payload['qty']                = $qty;
        $payload['baseTypeID']         = $baseTypeID;
        $payload['BPCmaterials']       = $BPCmaterials;
        $payload['materials_required'] = $materials_required;
        $payload['time']               = \Carbon\Carbon::now()->addSeconds($time)->diff(\Carbon\Carbon::now());
        $payload['BPCskills']          = $BPCskills;
        
        return \View::make('ram.manufacture.calc')->with('payload', $payload);
    }

    public function getInvention()
    {
        //
    }

    public function postInvention()
    {
        //
    }

    /**
     * @return \View|mixed
     */
    public function getCalculation()
    {
        $characters = \DB::Table('eve_account_apikeyinfo_characters')
            ->join('seit_keys', 'seit_keys.keyID', '=', 'eve_account_apikeyinfo_characters.keyID')
            ->select('characterID', 'characterName')
            ->where('seit_keys.user_id', '=', \Auth::user()->id)
            ->orderBy('characterName')
            ->lists('characterName', 'characterID');

        return \View::make('ram.calculate.view')
            ->with('characters', $characters);
    }

    /**
     * @return \View|mixed
     */
    public function postCalculation()
    {
        $errors = array();

        if (\Input::get('type', 0) === null) {
            $errors[] = "No Type Selected.";
        }

        if (\Input::get('system', 0) === null) {
            $errors[] = "No System selected.";
        }

        if (count($errors) > 0) {
            return redirect()->back()->with('errors', $errors)->withInput();
        }

        $level_modifier = array(
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
            10 => 256000
        );

        // see https://github.com/aineko-m/iveeCore/blob/850fb60b125599efde5bb76cf3b25e0465f6d7d3/iveeCore/IndustryModifier.php#L192
        //$te_modifier = ;
        //$me_modifier = ;

        $system_indices = \DB::Table('crest_industry_systems')
            ->where('solarSystemID', '=', \Input::get('system', 0))
            ->get();
        
        $times = \DB::Table('industryActivity')
            ->where('typeID', '=', \Input::get('type', 0))
            ->whereIn('activityID', array(3,4))
            ->get();
        
        if (\Input::has('me')) {
            list($ME_start, $ME_end) = explode(",", \Input::get('me'));
        } else {
            $ME_start = 0;
            $ME_end = 10;
        }
        
        if (\Input::has('te')) {
            list($TE_start, $TE_end) = explode(",", \Input::get('te'));
        } else {
            $TE_start = 0;
            $TE_end = 20;
        }

        $payload['input'] = \Input::all();
        $payload['level_modifier'] = $level_modifier;
        $payload['system_indices'] = $system_indices;
        $payload['times'] = $times;
        $payload['ME_start'] = $ME_start;
        $payload['TE_start'] = $ME_end;
        $payload['ME_end'] = $TE_start;
        $payload['TE_end'] = $TE_end;


        return \View::make('debug')
            ->with('payload', $payload);
    }

    /**
     * Queries DB for Blueprints and builds an report view
     *
     * @return \View|mixed
     */
    public function getBlueprints()
    {
        /*
            SELECT seit_dev.invTypes.typeName, seit_dev.eve_character_blueprints.*#, COUNT(1)
            FROM seit_dev.eve_character_blueprints
            JOIN seit_dev.invTypes ON seit_dev.invTypes.typeID = seit_dev.eve_character_blueprints.typeID
            WHERE seit_dev.eve_character_blueprints.runs = -1
            GROUP BY seit_dev.eve_character_blueprints.typeID, seit_dev.eve_character_blueprints.quantity, seit_dev.eve_character_blueprints.runs
            ORDER BY seit_dev.invTypes.typeName ASC;
        */
        $payload['blueprints'] = \DB::Table('eve_character_blueprints')
            ->select('invTypes.typeName', 'eve_character_blueprints.*', 'eve_account_apikeyinfo_characters.*', \DB::Raw('COUNT(1) as qty'))
            ->join('invTypes', 'invTypes.typeID', '=', 'eve_character_blueprints.typeID')
            ->join('eve_account_apikeyinfo_characters', 'eve_account_apikeyinfo_characters.characterID', '=', 'eve_character_blueprints.characterID')
            //->where('eve_character_blueprints.runs', '=', -1)
            ->groupBy('eve_character_blueprints.typeID', 'eve_character_blueprints.quantity', 'eve_character_blueprints.runs')
            ->orderBy('invTypes.typeName', 'asc')
            ->get();

        return \View::make('ram.blueprints.view')
            ->with('payload', $payload);
    }
}
