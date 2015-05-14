<?php namespace SeIT\Http\Controllers;

/**
 * Class DevController
 * @package SeIT\Http\Controllers
 */
class DevController extends Controller
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
     * @return $this
     */
    public function getDebug()
    {
        $payload = null;
        return \View::make('debug')
        ->with('payload', $payload);
    }
}
