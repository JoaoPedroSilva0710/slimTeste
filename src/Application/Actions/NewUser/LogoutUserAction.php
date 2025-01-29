<?php

namespace App\Application\Actions\NewUser;

use Slim\Psr7\Response;

class LogoutUserAction extends UserAction
{
    protected function action() : Response
    {
        if(isset($_SESSION)) session_unset();

        return $this->response->withHeader('Location', '/')->withStatus(302);
    }}
