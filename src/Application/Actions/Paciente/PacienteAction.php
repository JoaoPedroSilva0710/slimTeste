<?php

namespace App\Application\Actions\Paciente;

use Psr\Log\LoggerInterface;
use App\Application\Actions\Action;
use App\Domain\Paciente\PacienteRepositoryInterface;

abstract class PacienteAction extends Action
{

    public function __construct(protected LoggerInterface $logger, protected PacienteRepositoryInterface $pacienteRepository)
    {
        parent::__construct($logger);
        $this->logger->info('Paciente Constuido');
    }
}
