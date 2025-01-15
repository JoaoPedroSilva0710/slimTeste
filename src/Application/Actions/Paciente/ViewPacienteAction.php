<?php

namespace App\Application\Actions\Paciente;

use App\Application\Actions\Paciente\PacienteAction;
use Slim\Psr7\Response;

class ViewPacienteAction extends PacienteAction
{
    protected function action() : Response{
        $pacienteId = (int) $this->resolveArg('id');
        $paciente = $this->pacienteRepository->findPacienteOfId($pacienteId);

        $this->logger->info("User of id {$pacienteId} was viewed.");

        return $this->respondWithData($paciente);
    }

}
