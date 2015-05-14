<?php namespace SeIT\Http\Controllers;

use \SeIT\Services\BaseApi as EveApi;
use \Pheal\Pheal;

/**
 * Class ProfileController
 * @package SeIT\Http\Controllers
 */
class ProfileController extends Controller
{

    /**
     * @param array $parameters
     * @return \Illuminate\Http\RedirectResponse
     */
    public function missingMethod($parameters = array())
    {
        return redirect()->action('ProfileController@getIndex');
    }

    /**
     * @return $this
     */
    public function getIndex()
    {
        $user = \Auth::user();
        $keys = \DB::Table('seit_keys')
            ->where('user_id', \Auth::id())
            ->join('eve_account_apikeyinfo', 'eve_account_apikeyinfo.keyID', '=', 'seit_keys.keyID')
            ->orderBy('type')
            ->get();
        $ssolinks = \DB::Table('seit_crestlink')
            ->where('userID', '=', \Auth::id())
            ->get();
        return \View::make('profile.index')
            ->with('user', $user)
            ->with('keys', $keys)
            ->with('ssolinks', $ssolinks);
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \SeIT\Exceptions\APIServerDown
     */
    public function postAddKey()
    {
        $keyID = \Input::get('keyID');
        $vCode = \Input::get('vCode');
        $errors = null;

        // static pre-check
        EveApi::validateKeyPair($keyID, $vCode);

        // init phealng config
        EveApi::bootstrap();

        // validate
        $pheal = new Pheal($keyID, $vCode);
        try {
            $phealResponse = $pheal->accountScope->APIKeyInfo();
        } catch (\Pheal\Exceptions\APIException $e) {
            $errors[] = \DB::Table('eve_errorlist')
                ->where('errorCode', '=', $e->code)
                ->pluck('errorText');
        }

        if (\Carbon\Carbon::parse($phealResponse->expires)->lt(\Carbon\Carbon::now())) {
            $errors[] = "Key has already expired.";
        }


        if (\DB::Table('seit_keys')->where('keyID', $keyID)->where('user_id', \Auth::id())->count()>0) {
            $errors[] = 'Duplicate Key on User';
        } else {
            $key = new \SeIT\SeITKeys();
            $key->user_id = \Auth::id();
            $key->keyID = $keyID;
            $key->vCode = $vCode;
            $key->isOk = true;
            $key->save();
        }
        if (count($errors) > 0) {
            return redirect()->back()->with('errors', $errors)->withInput();
        } else {
            return redirect()->action('ProfileController@getIndex');
        }
    }
}
