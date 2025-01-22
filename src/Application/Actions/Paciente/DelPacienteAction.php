<?php

declare(strict_types=1);

namespace App\Application\Actions\Paciente;

use App\Domain\Mensagem;
use Exception;
use Psr\Http\Message\ResponseInterface;

class DelPacienteAction extends PacienteAction
{
    protected function action(): ResponseInterface
    {
        $data = $this->request->getParsedBody();

        $id = (int) $data['id'];

        try {
            $return = $this->pacienteRepository->delete($id);

        } catch (Exception $e) {
            $return = Mensagem::response('error', $e->getMessage(), $e->getCode());
            
            return $this->respondWithData($return[0], $return[1]);

        }

        return $this->respondWithData($return[0], $return[1]);

    }
}
