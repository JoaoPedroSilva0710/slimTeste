<?php

declare(strict_types=1);

use Slim\App;
use Slim\Views\Twig;
use PhpParser\Node\Expr\List_;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Actions\User\ListUsersAction;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Paciente\PacienteAction;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\Paciente\ListPacienteAction;
use App\Application\Actions\Paciente\ViewPacienteAction;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function ($request, $response, $args) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'home.html');
    });
 

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->group('/pacientes', function (Group $group) {
    $group->get('', ListPacienteAction::class);
    });
};
