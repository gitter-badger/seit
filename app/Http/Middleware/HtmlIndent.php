<?php namespace SeIT\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Gajus\Dindent\Indenter;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;

/**
 * Class HtmlIndent
 * @package SeIT\Http\Middleware
 */
class HtmlIndent
{

    /**
    * @var $app Application object
    */
    protected $app;

    /**
    * @var $indenter Indenter Object
    */
    protected $indenter;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->indenter = new Indenter();
    }

    /**
     * @param Request $request
     * @param callable $next
     * @return Response
     * @throws \Gajus\Dindent\Exception\RuntimeException
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->ajax()) {
            return $response;
        }

        if (($response instanceof BinaryFileResponse) || ($response instanceof JsonResponse) ||
        ($response instanceof RedirectResponse) || ($response instanceof StreamedResponse)) {
            return $response;
        }

        // Convert unknown responses
        if (!$response instanceof Response) {
            $response = new Response($response);
            if (!$response->headers->has('content-type')) {
                $response->headers->set('content-type', 'text/html');
            }
        }

        $contentType = $response->headers->get('content-type');
        
        if (str_contains($contentType, 'text/html')) {
            $response->setContent($this->indenter->indent($response->getContent()));
        }
        
        return $response;
    }
}
