<?php

namespace App\Application\Actions\Paciente;

use Exception;
use Slim\Psr7\Response;
use App\Domain\Mensagem;

class ListPacienteAction extends PacienteAction
{
    protected function action() : Response 
    {
        try {
            
            $pacientes = $this->pacienteRepository->findAll();

        } catch (Exception $e) {
            $exception = Mensagem::response('error', $e->getMessage(), $e->getCode());
            
            return $this->respondWithData($exception[0], $exception[1]);
            

        }
        return $this->respondWithData($pacientes);

    }
}
