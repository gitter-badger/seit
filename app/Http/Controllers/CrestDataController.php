<?php namespace SeIT\Http\Controllers;

/**
 * Class CrestDataController
 * @package SeIT\Http\Controllers
 */
class CrestDataController extends Controller
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
     * @return mixed returns basic UI with all available Regions
     */
    public function getIndustryRegionalIndexes()
    {
        $regionsMap = array('' => '');
        $query = \DB::Table('mapRegions as mr')
            ->select('mr.regionID', 'mr.regionName')
            ->where('mr.regionID', '<', 11000000)
            ->orderBy('mr.regionName')
            ->get();

        foreach ($query as $region) {
            $regionsMap[$region->regionID] = $region->regionName;
        }
        return \View::make('crest.industry.index.view')
            ->with('regionsMap', $regionsMap);
    }
    
    /**
     * @return mixed returns AJAX response for regionID
     */
    public function postIndustryRegionalIndexes()
    {
        $regionID = (int) \Input::get('regionID');

        $payload = \DB::Table('crest_industry_systems as cis')
            ->join('mapSolarSystems as mss', 'mss.solarSystemID', '=', 'cis.solarSystemID')
            ->select(
                'mss.solarSystemName',
                'cis.manufacturingIndex',
                'cis.meResearchIndex',
                'cis.teResearchIndex',
                'cis.copyIndex',
                'cis.inventionIndex',
                'mss.security'
            )
            ->where('mss.regionID', $regionID)
            ->orderBy('mss.solarSystemName')
            ->get();

        return \View::make('crest.industry.index.ajax')
            ->with('payload', $payload);
    }

    /**
     * @return $this
     */
    public function getIndustryFacilityData()
    {
        $regionsMap = array('' => '');
        $query = \DB::Table('mapRegions as mr')
            ->select('mr.regionID', 'mr.regionName')
            ->where('mr.regionID', '<', 11000000)
            ->orderBy('mr.regionName')
            ->get();

        foreach ($query as $region) {
            $regionsMap[$region->regionID] = $region->regionName;
        }
        return view('crest.industry.facility.view')
            ->with('regionsMap', $regionsMap);
    }

    /**
     * @return $this
     */
    public function postIndustryFacilityData()
    {
        $regionID = (int) \Input::get('regionID');

        $payload = \DB::Table('crest_industry_facilities as cif')
            ->join('mapSolarSystems as mss', 'mss.solarSystemID', '=', 'cif.solarSystemID')
            ->join('invTypes as it', 'it.typeID', '=', 'cif.stationType')
            ->select(
                'mss.solarSystemName',
                'cif.stationName',
                'cif.tax',
                'cif.ownerID',
                'it.typeName'
            )
            ->where('mss.regionID', $regionID)
            ->orderBy('mss.solarSystemName', 'cif.stationName')
            ->get();

        return view('crest.industry.facility.ajax')
            ->with('payload', $payload);
    }

    /**
     * @return $this
     */
    public function getMarketPriceIndex()
    {
        return view('crest.market.prices.view');
    }

    /**
     * @return $this
     */
    public function postMarketPriceIndex()
    {
        $groupID = (int) \Input::get('groupID');

        $payload = \DB::Table('crest_marketprices')
            ->select(
                'crest_marketprices.typeID',
                'invTypes.typeName',
                'invTypes.groupID',
                'crest_marketprices.adjustedPrice',
                'crest_marketprices.averagePrice',
                'invTypes.basePrice'
            )
            ->join('invTypes', 'crest_marketprices.typeID', '=', 'invTypes.typeID')
            ->where('invTypes.groupID', $groupID)
            ->orderBy('typeName')
            ->get();

        return view('crest.market.prices.ajax')
            ->with('payload', $payload);
    }
}
