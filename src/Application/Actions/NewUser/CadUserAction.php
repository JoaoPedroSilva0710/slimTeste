<?php

namespace App\Application\Actions\NewUser;

use Exception;
use Slim\Psr7\Response;
use App\Domain\Mensagem;
use App\Domain\NewUser\User;
use App\Domain\NewUser\Privileges;
use App\Application\Actions\NewUser\UserAction;

class CadUserAction extends UserAction
{
    const INVALID_PRIVILEGES = 'Este tipo de privilégio não existe';

    protected function action() : Response 
    {
        $data = $this->request->getParsedBody();

        $id = '' == $data['id'] ? null : (int) $data['id'];

        $privileges = '' == $data['privileges'] ?  null : Privileges::tryFrom($data['privileges']);

        if(!$privileges) {
            $return = Mensagem::response('error', self::INVALID_PRIVILEGES, 400);
            return $this->respondWithData($return[0], $return[1]);
        }

        try {
            $user = User::create($id, $data['name'], $data['cpf'], $data['email'], $data['password'], $privileges,  true);

        } catch (Exception $e) {
            $return = Mensagem::response('error', $e->getMessage(), $e->getCode());
            
            return $this->respondWithData($return[0], $return[1]);
        }


        $return = !$id ? $this->userRepository->cadastrate($user) : $this->userRepository->update($user);

        // $return = !$id ? '$this->pacienteRepository->cadastrate($paciente)' : '$this->pacienteRepository->update($paciente)';

        return $this->respondWithData($return[0], $return[1]);

    }

}
