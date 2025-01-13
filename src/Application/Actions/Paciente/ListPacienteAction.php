<?php

namespace App\Application\Actions\Paciente;

use Slim\Psr7\Response;

class ListPacienteAction extends PacienteAction
{
    protected function action() : Response 
    {
        return $this->respondWithData(['msg' => 'João passando']);

    }
}
