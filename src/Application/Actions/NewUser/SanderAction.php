<?php

declare(strict_types=1);

namespace App\Application\Actions\NewUser;

use Slim\Psr7\Response;
use App\Domain\NewUser\Privileges;



class SanderAction extends UserAction
{
    protected function action() : Response 
    {
        $privileges = $_SESSION['privileges'] ?? 'none';
        
        switch($privileges) {
            case 'user':
                return $this->response->withHeader('Location', '/listar')->withStatus(302);

            case 'admin':
               return $this->response->withHeader('Location', '/admin/users/listar')->withStatus(302);

            default:
                return $this->response->withHeader('Location', '/logout')->withStatus(302);
        }

    }
}
