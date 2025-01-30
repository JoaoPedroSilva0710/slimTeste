<?php

namespace App\Application\Middleware;

use Slim\Psr7\Response;
use App\Domain\NewUser\Privileges;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class GuestMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response {
        if (isset($_SESSION['user'])) {
            $response = new Response();

            return $response->withHeader('Location', '/listar')->withStatus(302);
        } 
        
        $response = $handler->handle($request);
        return $response;
    }
}
