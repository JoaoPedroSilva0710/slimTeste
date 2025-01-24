<?php

declare(strict_types=1);

use Slim\App;
use Slim\Views\Twig;
use PhpParser\Node\Expr\List_;
use App\Application\Actions\NewUser\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
// use App\Application\Actions\User\ViewUserAction;
// use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\NewUser\ListUsersAction;
use App\Application\Actions\Paciente\PacienteAction;
use App\Application\Actions\Paciente\CadPacienteAction;
use App\Application\Actions\Paciente\DelPacienteAction;
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

    $app->group('/admin', function (Group $group) {
        $group->get('/cadastrar', function ($request, $response, $args) {
            $view = Twig::fromRequest($request);
            return $view->render($response, 'cadastrarUsuario.html');
        }); 

        $group->get('/users/listar', function ($request, $response, $args) {
                $view = Twig::fromRequest($request);
                return $view->render($response, '/admin/users/listar.html');
            });

    });
    
    $app->get('/listar', function ($request, $response, $args) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'listar.html');
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->group('/pacientes', function (Group $group) {
    $group->get('', ListPacienteAction::class);
    $group->post('', CadPacienteAction::class);
    $group->get('/{id}', ViewPacienteAction::class);
    $group->post('/delete', DelPacienteAction::class);
    });
};
