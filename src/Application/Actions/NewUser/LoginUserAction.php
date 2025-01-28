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

            
        } catch (\Throwable $th) {
            $return = Mensagem::response('error', Sql::BD_ERRORS, 400);
            
            return $this->respondWithData($return[0],$return[1]);
        }

        if($logged[1] != 200) {
            return $this->respondWithData($logged[0], $logged[1]);
        }
        
        return $this->respondWithData($logged[0], $logged[1]);
    }
}
