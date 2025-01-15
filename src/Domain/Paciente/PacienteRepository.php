<?php

declare(strict_types=1);

namespace App\Domain\Paciente;

use Exception;
use App\Infrastructure\Sql\Sql;

class PacienteRepository implements PacienteRepositoryInterface
{
    const PACIENT_NOT_FOUND = 'O paciente não foi encontrado';

    public function __construct(protected Sql $sql)
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        $query = "SELECT * FROM usuarios";
        $stmt = $this->sql->prepare($query);
        $stmt->execute();
        $resp = $stmt->fetchAll(SQL::FETCH_ASSOC);
        
        return $resp;
        // return[
        //     Paciente::create(1, 'João', '01-02-2003', 'M', 'Lilian', 'joaosilva@gmail.com', '12345678912', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE),
        //     Paciente::create(2, 'Pedro', '01-02-2003', 'M', 'Lilian', 'pedrosilva@gmail.com', '123.456.789-13', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE),
        //     Paciente::create(3, 'Lucas', '01-02-2003', 'M', 'Lilian', 'lucasrodrigues@gmail.com', '22345678912', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE),
        //     Paciente::create(4, 'Giovani', '01-02-2003', 'M', 'Lilian', 'gurudoexcel@gmail.com', '32345678912', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE),
        //     Paciente::create(5, 'Tiago', '01-02-2003', 'M', 'Lilian', 'tiagoletieri@gmail.com', '42345678912', '03343010', 'Rua dos Alfeneiros', '10', 'bairro do trabalho', 'SP', TRUE)
        // ];
    }

    /**
     * {@inheritdoc}
     */
    public function findPacienteOfId(int $id): array
    {
        try{
        
        $query = "SELECT * FROM usuarios where id = :id";
        $stmt = $this->sql->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $resp = $stmt->fetchAll(SQL::FETCH_ASSOC);

        return $resp;
        } catch(Exception $e){
            die($e->getMessage());

        }
    }
}
