<?php

namespace App\Application\Actions\Paciente;

use Exception;
use Slim\Psr7\Response;

class ListPacienteAction extends PacienteAction
{
    protected function action() : Response 
    {
        try {
            
            $pacientes = $this->pacienteRepository->findAll();

        } catch (Exception $e) {

            

        }
        return $this->respondWithData($pacientes);

    }
}
