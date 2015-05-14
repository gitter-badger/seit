<?php namespace SeIT\Http\Controllers;

/**
 * Class DashboardController
 * @package SeIT\Http\Controllers
 */
class DashboardController extends Controller
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
     * @return mixed returns basic UI
     */
    public function getIndex()
    {
        $payload['count_error'] = \DB::Table('queue_information')
            ->where('status', 'Error')
            ->count();

        $payload['count_queued'] = \DB::Table('queue_information')
            ->where('status', 'Queued')
            ->count();

        $payload['count_working'] = \DB::Table('queue_information')
            ->where('status', 'Working')
            ->count();

        $payload['count_done'] = \DB::Table('queue_information')
            ->where('status', 'Done')
            ->count();

        $payload['count_failed'] = \DB::Table('failed_jobs')
            ->count();

        $payload['error'] = \DB::Table('queue_information')
            ->where('status', 'Error')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        $payload['queued'] = \DB::Table('queue_information')
            ->where('status', 'Queued')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        $payload['working'] = \DB::Table('queue_information')
            ->where('status', 'Working')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        $payload['done'] = \DB::Table('queue_information')
            ->where('status', 'Done')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();
        
        $payload['crestIndustrySystems'] = \DB::Table('crest_industry_systems')
            ->selectRaw('count(*) as count, min(updated_at) as min, max(updated_at) as max')
            ->first();

        $payload['crestIndustryFacilities'] = \DB::Table('crest_industry_facilities')
            ->selectRaw('count(*) as count, min(updated_at) as min, max(updated_at) as max')
            ->first();

        $payload['crestMarketPrices'] = \DB::Table('crest_marketprices')
            ->selectRaw('count(*) as count, min(updated_at) as min, max(updated_at) as max')
            ->first();

        $payload['entities_unknown'] = \DB::Table('seit_entity_names_map')
            ->where('resolved', false)
            ->count();

        return \View::make('dashboard.index')
            ->with('payload', $payload);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRefreshIndustryFacilities()
    {
        \SeIT\Services\Queue::addCrestJob('\SeIT\Queues\Crest\IndustryFacilitiesUpdater');
        return redirect()
            ->action('DashboardController@getIndex')
            ->with('success', 'Refresh of Industry Facilities scheduled.');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRefreshIndustrySystems()
    {
        \SeIT\Services\Queue::addCrestJob('\SeIT\Queues\Crest\IndustrySystemsUpdater');
        return redirect()
            ->action('DashboardController@getIndex')
            ->with('success', 'Refresh of Industry Systems scheduled.');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRefreshMarketPrices()
    {
        \SeIT\Services\Queue::addCrestJob('\SeIT\Queues\Crest\MarketPricesUpdater');
        return redirect()
            ->action('DashboardController@getIndex')
            ->with('success', 'Refresh of Market Prices scheduled.');
    }
}
