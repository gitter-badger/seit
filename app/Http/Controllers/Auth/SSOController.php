<?php namespace SeIT\Http\Controllers\Auth;

use SeIT\Http\Controllers\Controller;
use \GuzzleHttp\Client as GuzzleClient;

/**
 * Class SSOController
 * @package SeIT\Http\Controllers
 */
class SSOController extends Controller
{
    private $userAgent;

    public function __construct()
    {
        $this->userAgent = 'SeIT/SSO-Bridge v.' . \Config::get('seit.version') . ' (Contact '.\Config::get('seit.owner').')';
    }

    /**
     * @return $this|bool
     */
    public function getCallback()
    {
        if (\Config::get('seit.sso_clientid') === null && \Config::get('seit.sso_clientid') === null) {
            abort(404);
        } else {
            // Decide which baseUrl
            if (\Config::get('seit.sso_uselive')) {
                $baseUrl = 'https://login.eveonline.com';
            } else {
                $baseUrl = 'https://sisilogin.testeveonline.com';
            }

            // Build final Urls.
            $tokenUrl = $baseUrl . '/oauth/token';
            $verifyUrl =  $baseUrl . '/oauth/verify';

            // Create Guzzle Client
            $client = new GuzzleClient();
            $request = $client->createRequest('POST', $tokenUrl);
            $request->setHeader('User-Agent', $this->userAgent);
            $request->addHeader('Authorization', 'Basic ' . base64_encode(\Config::get('seit.sso_clientid') .':'. \Config::get('seit.sso_secret')));
            
            $requestBody = $request->getBody();
            $requestBody->setField('grant_type', 'authorization_code');
            $requestBody->setField('code', \Input::get('code'));
            $token = $client->send($request);
            
            if (!$token->getStatusCode() == 200) {
                return "init";
            } else {
                $tokenJSON = $token->json();
            }

            $request = $client->createRequest('GET', $verifyUrl);
            $request->setHeader('User-Agent', $this->userAgent);
            $request->addHeader('Authorization', 'Bearer ' . $tokenJSON['access_token']);
            $verify = $client->send($request);


            if (!$verify->getStatusCode() == 200) {
                return "init";
            } else {
                $verifyJSON = $verify->json();
            }

            $crestLink = \SeIT\Models\SeITCrestLink::where('characterID', $verifyJSON['CharacterID'])
                ->where('CharacterOwnerHash', '=', $verifyJSON['CharacterOwnerHash'])
                ->first();

            if (\Input::get('state') == 'linkAccount' && !$crestLink) {
                $crestLink = new \SeIT\SeITCrestLink();
                
                $crestLink->characterID        = $verifyJSON['CharacterID'];
                $crestLink->characterName      = $verifyJSON['CharacterName'];
                $crestLink->expires            = $verifyJSON['ExpiresOn'];
                $crestLink->scopes             = $verifyJSON['Scopes'];
                $crestLink->tokenType          = $verifyJSON['TokenType'];
                $crestLink->characterOwnerHash = $verifyJSON['CharacterOwnerHash'];
                
                $crestLink->save();

            } elseif (\Input::get('state') == 'loginAccount' && $crestLink) {
                \Auth::loginUsingId($crestLink->userID);
                return redirect('/');
            } elseif (\Input::get('state') == 'loginAccount' && !$crestLink) {
                return redirect()->action('SeIT\Http\Controllers\Auth\AuthController@getLogin');
            }
        }
        return redirect()->action('SeIT\Http\Controllers\Auth\AuthController@getLogin');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getInitLink()
    {
        if (\Config::get('seit.sso_uselive')) {
            $url = 'https://login.eveonline.com/oauth/authorize?';
        } else {
            $url = 'https://sisilogin.testeveonline.com/oauth/authorize?';
        }
        $url = $url . 'response_type=code&redirect_uri=' . \Config::get('seit.sso_callback');
        $url = $url . '&client_id=' . \Config::get('seit.sso_clientid') . '&scope&state=linkAccount';

        return redirect($url);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getInitLogin()
    {
        if (\Config::get('seit.sso_uselive')) {
            $url = 'https://login.eveonline.com/oauth/authorize?';
        } else {
            $url = 'https://sisilogin.testeveonline.com/oauth/authorize?';
        }
        $url = $url . 'response_type=code&redirect_uri=' . \Config::get('seit.sso_callback');
        $url = $url . '&client_id=' . \Config::get('seit.sso_clientid') . '&scope&state=loginAccount';

        return redirect($url);
    }
}
