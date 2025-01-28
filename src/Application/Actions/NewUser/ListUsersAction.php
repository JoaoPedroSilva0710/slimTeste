<?php

declare(strict_types=1);

namespace App\Application\Actions\NewUser;

use Exception;
use App\Application\Actions\NewUser\UserAction;
use App\Domain\Mensagem;
use App\Infrastructure\Sql\Sql;
use Psr\Http\Message\ResponseInterface as Response;

class ListUsersAction extends UserAction
{
    // const BD_ERRORS = 'Há algum erro na aplicação, caso o erro persistir procure os administradores';
    /**
     * {@inheritdoc}
     */
    protected function action() : Response 
    {
        try {
            
            $users = $this->userRepository->findAll();

        } catch (Exception $e) {

            return Mensagem::response('error', Sql::BD_ERRORS, 400);

        }
        return $this->respondWithData($users);

    }
}
