<?php

namespace App\Application\Actions\Paciente;

use Slim\Psr7\Response;

class ListPacienteAction extends PacienteAction
{
    protected function action() : Response 
    {
        $pacientes = $this->pacienteRepository->findAll();
        return $this->respondWithData($pacientes);

    }
}
