<?php

declare(strict_types=1);

namespace App\Application\Actions\NewUser;

use Exception;
use App\Application\Actions\NewUser\UserAction;
use App\Domain\Mensagem;
use Psr\Http\Message\ResponseInterface as Response;

class ListUsersAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action() : Response 
    {
        try {
            
            $users = $this->userRepository->findAll();

        } catch (Exception $e) {

            return Mensagem::response('error', $e->getMessage(), $e->getCode());
            
        }
        return $this->respondWithData($users);

    }
}
