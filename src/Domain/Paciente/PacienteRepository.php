<?php

declare(strict_types=1);

namespace App\Domain\Paciente;

use Exception;

class PacienteRepository implements PacienteRepositoryInterface
{
    const PACIENT_NOT_FOUND = 'O paciente não foi encontrado';

    public function __construct()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return[
            [Paciente::create(1, 'João', '01-02-2003', 'M', 'Lilian', 'joaosilva@gmail.com', '12345678912', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE)],
            [Paciente::create(2, 'Pedro', '01-02-2003', 'M', 'Lilian', 'pedrosilva@gmail.com', '123.456.789-13', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE)],
            [Paciente::create(3, 'Lucas', '01-02-2003', 'M', 'Lilian', 'lucasrodrigues@gmail.com', '22345678912', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE)],
            [Paciente::create(4, 'Giovani', '01-02-2003', 'M', 'Lilian', 'gurudoexcel@gmail.com', '32345678912', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE)],
            [Paciente::create(5, 'Tiago', '01-02-2003', 'M', 'Lilian', 'tiagoletieri@gmail.com', '42345678912', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE)]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): array
    {
        // if (!isset($this->pacientes[$id])) {
        //     throw new Exception(self::PACIENT_NOT_FOUND);
        // }

        // return $this->pacientes[$id];
        return [Paciente::create(1, 'João', '01-02-2003', 'M', 'Lilian', 'joaosilva@gmail.com', '12345678912', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE)];
    }
}
