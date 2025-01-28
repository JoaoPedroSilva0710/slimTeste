<?php

namespace App\Application\Middleware;

use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Domain\User\User;
class AdminMiddleware
{
        /**
     * Example middleware invokable class
     *
     * @param  Request        $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        if (!isset($_SESSION['user'])) {
            $response = new Response();

            return $response->withHeader('Location', '/')->withStatus(302);
        }

        $response = $handler->handle($request);
        return $response;

    }
}
