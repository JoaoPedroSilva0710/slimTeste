<?php

declare(strict_types=1);

namespace App\Application\Actions\NewUser;

use Exception;
use App\Domain\Mensagem;
use App\Infrastructure\Sql\Sql;
use App\Application\Actions\NewUser\UserAction;
use Psr\Http\Message\ResponseInterface as Response;

class LoginUserAction extends UserAction
{
    protected function action() : Response 
    {
        $data = $this->request->getParsedBody();
        
        $email = $data['email'];
        
        $password = $data['password'];
        
        try {
            $logged = $this->userRepository->login($email, $password);

            
        } catch (\Exception $e) {
            $exception = Mensagem::response('error', $e->getMessage(), $e->getCode());
            
            return $this->respondWithData($exception[0], $exception[1]);
        }

        if($logged[1] != 200) {
            return $this->respondWithData($logged[0], $logged[1]);
        }
        
        return $this->respondWithData($logged[0], $logged[1]);
    }
}
