<?php namespace SeIT\Http\Controllers;

use SeIT\Services\ResearchAndManufacture;

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
        $errors     = array();
        $payload    = array();
        $me         = \Input::get('me', '');
        $te         = \Input::get('te', '');
        $qty        = \Input::get('qty', '');
        $type       = \Input::get('type', '');
        $system     = \Input::get('system', '');
        $assembly   = \Input::get('assembly', '');
        $character  = \Input::get('character', '');
        
        if ($type == '') {
            $errors[] = "No Type Selected.";
        }

        if ($system == '') {
            $errors[] = "No System selected.";
        }

        if ($qty == '' || $qty <= 0) {
            $errors[] = "You can not build something with 0 runs.";
        }
        
        if ($character  == '') {
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

        $jobFee = ResearchAndManufacture::getJobFeeManufacture(
            $type,
            $system,
            $qty
        );

        $jobTime = ResearchAndManufacture::getJobTimeManufacture(
            $type,
            $qty,
            $te,
            $character,
            $assembly
        );

        $jobMaterials = \SeIT\Services\ResearchAndManufacture::getMaterialsManufacture(
            $type,
            $qty,
            $me,
            $assembly
        );
        
        $payload['input']        = \Input::all();
        $payload['qty']          = $qty;
        $payload['jobMaterials'] = $jobMaterials;
        $payload['jobTime']      = \Carbon\Carbon::now()->addSeconds($jobTime)->diff(\Carbon\Carbon::now());
        $payload['jobFee']       = $jobFee;
        
        return \View::make('ram.manufacture.result')->with('payload', $payload);
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
    public function getResearch()
    {
        $characters = \DB::Table('eve_account_apikeyinfo_characters')
            ->join('seit_keys', 'seit_keys.keyID', '=', 'eve_account_apikeyinfo_characters.keyID')
            ->select('characterID', 'characterName')
            ->where('seit_keys.user_id', '=', \Auth::user()->id)
            ->orderBy('characterName')
            ->lists('characterName', 'characterID');

        return \View::make('ram.research.view')
            ->with('characters', $characters);
    }

    /**
     * @return \View|mixed
     */
    public function postResearch()
    {
        $errors = array();
        $type = \Input::get('type', '');
        $system = \Input::get('system', '');
        $character = \Input::get('character', '');


        if ($type == '') {
            $errors[] = 'No Type Selected.';
        }

        if ($system == '') {
            $errors[] = 'No System selected.';
        }

        if ($character == '') {
            $errors[] = 'No Character selected.';
        }

        if (count($errors) > 0) {
            return redirect()->back()->with('errors', $errors)->withInput();
        }

        if (\Input::has('te')) {
            list($TEStart, $TEEnd) = explode(",", \Input::get('te'));
        } else {
            $TEStart = 0;
            $TEEnd = 20;
        }

        if (\Input::has('me')) {
            list($MEStart, $MEEnd) = explode(",", \Input::get('me'));
        } else {
            $MEStart = 0;
            $MEEnd = 10;
        }

        $lab = \Input::get('laboratory');

        $characters = \DB::Table('eve_account_apikeyinfo_characters')
            ->join('seit_keys', 'seit_keys.keyID', '=', 'eve_account_apikeyinfo_characters.keyID')
            ->select('characterID', 'characterName')
            ->where('seit_keys.user_id', '=', \Auth::user()->id)
            ->orderBy('characterName')
            ->lists('characterName', 'characterID');

        $jobFeeTE = ResearchAndManufacture::getJobFeeResearch(
            $type,
            ResearchAndManufacture::RESEARCH_TE,
            $system,
            $character,
            $TEStart,
            $TEEnd
        );
        $jobFeeME = ResearchAndManufacture::getJobFeeResearch(
            $type,
            ResearchAndManufacture::RESEARCH_ME,
            $system,
            $character,
            $MEStart,
            $MEEnd
        );

        $jobTimeTE =  \Carbon\Carbon::now()
            ->addSeconds(
                ResearchAndManufacture::getJobTimeResearch(
                    $type,
                    ResearchAndManufacture::RESEARCH_TE,
                    $system,
                    $character,
                    $TEStart,
                    $TEEnd,
                    $lab
                )
            )
            ->diff(\Carbon\Carbon::now());

        $jobTimeME =  \Carbon\Carbon::now()
            ->addSeconds(
                ResearchAndManufacture::getJobTimeResearch(
                    $type,
                    ResearchAndManufacture::RESEARCH_ME,
                    $system,
                    $character,
                    $MEStart,
                    $MEEnd,
                    $lab
                )
            )
            ->diff(\Carbon\Carbon::now());

        $payload['input'] = \Input::all();
        $payload['jobFeeME'] = $jobFeeME;
        $payload['jobFeeTE'] = $jobFeeTE;
        $payload['jobTimeME'] = $jobTimeME;
        $payload['jobTimeTE'] = $jobTimeTE;
        $payload['characters'] = $characters;

        return \View::make('ram.research.result')
            ->with('payload', $payload);
    }

    /**
     * Queries DB for Blueprints and builds an report view
     *
     * @return \View|mixed
     */
    public function getBlueprints()
    {
        $payload['blueprints'] = \DB::Table('eve_character_blueprints')
            ->join('invTypes', 'invTypes.typeID', '=', 'eve_character_blueprints.typeID')
            ->join('eve_character_sheet', 'eve_character_sheet.characterID', '=', 'eve_character_blueprints.characterID')
            ->join('invGroups', 'invGroups.groupID', '=', 'invTypes.groupID')
            ->whereIn('eve_character_blueprints.characterID', \SeIT\Services\DB::getCharacterIDsByUserID(\Auth::user()->id))
            ->orderBy('invTypes.typeName', 'asc')
            ->get();

        return \View::make('ram.blueprints.view')
            ->with('payload', $payload);
    }

    public function getJobs()
    {
        $payload['jobs'] = \DB::Table('eve_character_industryjobs')
            ->whereIn('eve_character_industryjobs.installerID', \SeIT\Services\DB::getCharacterIDsByUserID(\Auth::user()->id))
            ->get();

        return \View::make('debug')
            ->with('payload', $payload);
    }
}
