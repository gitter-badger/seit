<?php namespace SeIT\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\Security\Core\Util\StringUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use RuntimeException;

/**
 * Class VerifyCsrfToken
 * @package SeIT\Http\Middleware
 */
class VerifyCsrfToken
{

    /**
     * The encrypter implementation.
     *
     * @var \Illuminate\Contracts\Encryption\Encrypter
     */
    protected $encrypter;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Encryption\Encrypter $encrypter
     */
    public function __construct(Encrypter $encrypter)
    {
        $this->encrypter = $encrypter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->isReading($request) || $this->tokensMatch($request)) {
            $response = $next($request);
            
            if ($response instanceof Response) {
                return $this->addCookieToResponse($request, $response);
            } elseif ($response instanceof RedirectResponse) {
                return $this->addCookieToRedirectResponse($request, $response);
            } elseif ($response instanceof JsonResponse) {
                return $this->addCookieToJSONResponse($request, $response);
            } else {
                throw new RuntimeException('No Valid Response Type in CSRF Check - ' . get_class($response));
            }
        }

        throw new TokenMismatchException;
    }

    /**
     * Determine if the session and input CSRF tokens match.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch(Request $request)
    {
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');

        if (! $token && $header = $request->header('X-XSRF-TOKEN')) {
            $token = $this->encrypter->decrypt($header);
        }

        return StringUtils::equals($request->session()->token(), $token);
    }

    /**
     * Add the CSRF token to the response cookies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return \Illuminate\Http\Response
     */
    protected function addCookieToResponse(Request $request, Response $response)
    {
        $response->headers->setCookie(
            new Cookie('XSRF-TOKEN', $request->session()->token(), time() + 60 * 120, '/', null, false, false)
        );

        return $response;
    }

    /**
     * Add the CSRF token to the redirectresponse cookies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\RedirectResponse  $response
     * @return \Illuminate\Http\Response
     */
    protected function addCookieToRedirectResponse(Request $request, RedirectResponse $response)
    {
        $response->headers->setCookie(
            new Cookie('XSRF-TOKEN', $request->session()->token(), time() + 60 * 120, '/', null, false, false)
        );

        return $response;
    }

    /**
     * Add the CSRF token to the jbosnresponse cookies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\JsonResponse  $response
     * @return \Illuminate\Http\Response
     */
    protected function addCookieToJSONResponse(Request $request, JsonResponse $response)
    {
        $response->headers->setCookie(
            new Cookie('XSRF-TOKEN', $request->session()->token(), time() + 60 * 120, '/', null, false, false)
        );

        return $response;
    }

    /**
     * Determine if the HTTP request uses a ‘read’ verb.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isReading(Request $request)
    {
        return in_array($request->method(), ['HEAD', 'GET', 'OPTIONS']);
    }
}
