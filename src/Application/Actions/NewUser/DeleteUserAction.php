<?php

declare(strict_types=1);

namespace App\Application\Actions\NewUser;

use Exception;
use App\Application\Actions\NewUser\UserAction;
use App\Domain\Mensagem;
use App\Infrastructure\Sql\Sql;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteUserAction extends UserAction
{

    /**
     * {@inheritdoc}
     */
    protected function action() : Response 
    {
        $data = $this->request->getParsedBody();

        $id = (int) $data['id'];
        
        try {
            $return = $this->userRepository->delete($id);

        } catch (Exception $e) {
            $exception = Mensagem::response('error', $e->getMessage(), $e->getCode());
            
            return $this->respondWithData($exception[0], $exception[1]);

        }
        return $this->respondWithData($return[0], $return[1]);

    }
}
