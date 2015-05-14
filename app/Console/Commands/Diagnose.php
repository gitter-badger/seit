<?php namespace SeIT\Console\Commands;

use Illuminate\Console\Command;
use SeIT\Queues\Crest\CrestBase;

/**
 * Class Diagnose
 * @package SeIT\Console\Commands
 */
class Diagnose extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'seit:diagnose';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs Diagnose task(s)';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This is a diagnose command to test various things.
     * Currenty checks EvE Crest connection.
     */
    public function fire()
    {
        try {
            $this->info("BannedCall: " . 
            \SeIT\Models\BannedCall::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model BannedCall');
        }
        try {
            $this->info("CachedUntil: " . 
            \SeIT\Models\CachedUntil::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model CachedUntil');
        }
        try {
            $this->info("CrestIndustryFacilities: " . 
            \SeIT\Models\CrestIndustryFacilities::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model CrestIndustryFacilities');
        }
        try {
            $this->info("CrestIndustrySystems: " . 
            \SeIT\Models\CrestIndustrySystems::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model CrestIndustrySystems');
        }
        try {
            $this->info("CrestMarketPrices: " . 
            \SeIT\Models\CrestMarketPrices::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model CrestMarketPrices');
        }
        try {
            $this->info("EveAccountAccountstatus: " . 
            \SeIT\Models\EveAccountAccountstatus::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveAccountAccountstatus');
        }
        try {
            $this->info("EveAccountAPIKeyInfoCharacters: " . 
            \SeIT\Models\EveAccountAPIKeyInfoCharacters::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveAccountAPIKeyInfoCharacters');
        }
        try {
            $this->info("EveAccountAPIKeyInfo: " . 
            \SeIT\Models\EveAccountAPIKeyInfo::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveAccountAPIKeyInfo');
        }
        try {
            $this->info("EveAlliancelistMembercorporations: " . 
            \SeIT\Models\EveAlliancelistMembercorporations::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveAlliancelistMembercorporations');
        }
        try {
            $this->info("EveAlliancelist: " . 
            \SeIT\Models\EveAlliancelist::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveAlliancelist');
        }
        try {
            $this->info("EveApiCalllist: " . 
            \SeIT\Models\EveApiCalllist::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveApiCalllist');
        }
        try {
            $this->info("EveCharacterBlueprints: " . 
            \SeIT\Models\EveCharacterBlueprints::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveCharacterBlueprints');
        }
        try {
            $this->info("EveCharacterCharacterSheetImplants: " . 
            \SeIT\Models\EveCharacterCharacterSheetImplants::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveCharacterCharacterSheetImplants');
        }
        try {
            $this->info("EveCharacterCharacterSheetJumpCloneImplants: " . 
            \SeIT\Models\EveCharacterCharacterSheetJumpCloneImplants::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveCharacterCharacterSheetJumpCloneImplants');
        }
        try {
            $this->info("EveCharacterCharacterSheetJumpClones: " . 
            \SeIT\Models\EveCharacterCharacterSheetJumpClones::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveCharacterCharacterSheetJumpClones');
        }
        try {
            $this->info("EveCharacterCharacterSheet: " . 
            \SeIT\Models\EveCharacterCharacterSheet::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveCharacterCharacterSheet');
        }
        try {
            $this->info("EveCharacterCharacterSheetSkills: " . 
            \SeIT\Models\EveCharacterCharacterSheetSkills::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveCharacterCharacterSheetSkills');
        }
        try {
            $this->info("EveConquerablestationlist: " . 
            \SeIT\Models\EveConquerablestationlist::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveConquerablestationlist');
        }
        try {
            $this->info("EveCorporationRolemap: " . 
            \SeIT\Models\EveCorporationRolemap::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveCorporationRolemap');
        }
        try {
            $this->info("EveErrorlist: " . 
            \SeIT\Models\EveErrorlist::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveErrorlist');
        }
        try {
            $this->info("EveNotificationtypes: " . 
            \SeIT\Models\EveNotificationtypes::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveNotificationtypes');
        }
        try {
            $this->info("EveReftypes: " . 
            \SeIT\Models\EveReftypes::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model EveReftypes');
        }
        try {
            $this->info("FailedJobs: " . 
            \SeIT\Models\FailedJobs::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model FailedJobs');
        }
        try {
            $this->info("QueueInformation: " . 
            \SeIT\Models\QueueInformation::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model QueueInformation');
        }
        try {
            $this->info("SeITCrestLink: " . 
            \SeIT\Models\SeITCrestLink::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model SeITCrestLink');
        }
        try {
            $this->info("SeITEntityNamesMap: " . 
            \SeIT\Models\SeITEntityNamesMap::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model SeITEntityNamesMap');
        }
        try {
            $this->info("SeITKeys: " . 
            \SeIT\Models\SeITKeys::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model SeITKeys');
        }
        try {
            $this->info("SeITMetadata: " . 
            \SeIT\Models\SeITMetadata::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model SeITMetadata');
        }
        try {
            $this->info("User: " . 
            \SeIT\Models\User::count());}
        catch (\Illuminate\Database\QueryException $e) {
            $this->error('Missing Table/Model User');
        }
    }
}
