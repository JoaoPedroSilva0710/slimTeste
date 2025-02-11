<?php

namespace App\Application\Actions\Paciente;

use Psr\Log\LoggerInterface;
use App\Application\Actions\Action;
use App\Domain\Paciente\PacienteRepositoryInterface;
use App\services\OwnAntixssInterface;

abstract class PacienteAction extends Action
{

    public function __construct(protected LoggerInterface $logger, protected PacienteRepositoryInterface $pacienteRepository, protected OwnAntixssInterface $antiXss)
    {
        parent::__construct($logger);
    }

    protected function sanitizeArray(array $array): array
    {
        foreach ($array as &$value) {
            $value = $this->antiXss->clean($value);
        }

        return $array;
    }
}
