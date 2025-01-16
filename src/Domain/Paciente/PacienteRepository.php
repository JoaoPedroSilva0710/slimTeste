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
        try {

        $query = "SELECT * FROM usuarios where ativo = TRUE";
        $stmt = $this->sql->prepare($query);
        $stmt->execute();
        $resp = $stmt->fetchAll(SQL::FETCH_ASSOC);
        
        return $resp;

        } catch(Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findPacienteOfId(int $id): array
    {
        try{
        
        $query = "SELECT * FROM usuarios WHERE id = :id AND ativo = TRUE";
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
