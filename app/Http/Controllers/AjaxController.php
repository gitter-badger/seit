<?php namespace SeIT\Http\Controllers;

/**
 * Class AjaxController
 * @package SeIT\Http\Controllers
 */
class AjaxController extends Controller
{
    /**
     * @param array $parameters
     * @return mixed|void
     */
    public function missingMethod($parameters = array())
    {
        \App::abort(404);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSystems()
    {
        if (!\Request::ajax()) {
            \App::abort(404);
        }

        $systemMap = \DB::Table('mapSolarSystems')
            ->select('solarSystemID as id', 'solarSystemName as text')
            ->where('solarSystemName', 'like', '%'.\Input::get('q').'%')
            ->orderBy('solarSystemName', 'asc')
            ->get();

        return \Response::json($systemMap);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSystemById()
    {
        if (!\Request::ajax()) {
            \App::abort(404);
        }

        $system = \DB::Table('mapSolarSystems')
            ->select('solarSystemID as id', 'solarSystemName as text')
            ->where('solarSystemID', '=', \Input::get('q'))
            ->first();

        return \Response::json($system);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTypes()
    {
        if (!\Request::ajax()) {
            \App::abort(404);
        }

        $typeMap = \DB::Table('invTypes')
            ->select('invTypes.typeID as id', 'invTypes.typeName as text')
            ->join('industryActivity', 'invTypes.typeID', '=', 'industryActivity.typeID')
            ->where('typeName', 'like', '%'.\Input::get('q').'%')
            ->where('invTypes.published', 1)
            ->where('industryActivity.activityID', 1)
            ->orderBy('typeName', 'asc')
            ->get();

        return \Response::json($typeMap);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTypeById()
    {
        if (!\Request::ajax()) {
            \App::abort(404);
        }

        $type = \DB::Table('invTypes')
            ->select('invTypes.typeID as id', 'invTypes.typeName as text')
            ->where('invTypes.published', 1)
            ->where('typeID', '=', \Input::get('q'))
            ->first();

        return \Response::json($type);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getQueueInformation()
    {
        if (!\Request::ajax()) {
            \App::abort(404);
        }

        $payload = array();

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

        return \Response::json($payload);
    }

    public function getMarketgroupTree()
    {
        return \Response::json(\SeIT\Services\DB::iterateMarketGroupData());
    }
}
