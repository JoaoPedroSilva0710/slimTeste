<?php

namespace App\Application\Middleware;

use App\Domain\NewUser\Privileges;
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


class AdminMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $privileges = $_SESSION['privileges'] ?? 'none';

        if (Privileges::Admin->value != $privileges) {

            $response = new Response();

            return $response->withHeader('Location', '/logout')->withStatus(302);

        }

        $response = $handler->handle($request);

        return $response;

    }
}
