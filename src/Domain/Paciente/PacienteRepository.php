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
            return $e->getMessage();
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
            return $e->getMessage();

        }
    }

    public function cadastrate(Paciente $paciente): array
    {
        try{
        
            $query = "UPDATE usuarios SET nome = :nome, data_nascimento = :data_nascimento, sexo = :sexo, nome_mae = :nome_mae, email = :email, cpf = :cpf, cep = :cep, nome_rua = :nome_rua, numero_casa = :numero_casa, bairro = :bairro, uf = :uf WHERE id = :id AND ativo = TRUE";
            $stmt = $this->sql->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $resp = $stmt->fetchAll(SQL::FETCH_ASSOC);
    
            return $resp;
            
            } catch(Exception $e){
                return $e->getMessage();
    
            }
    }

    public function delete(int $id): array
    {
        try{
        
            $query = "UPDATE usuarios SET nome = :nome, data_nascimento = :data_nascimento, sexo = :sexo, nome_mae = :nome_mae, email = :email, cpf = :cpf, cep = :cep, nome_rua = :nome_rua, numero_casa = :numero_casa, bairro = :bairro, uf = :uf WHERE id = :id AND ativo = TRUE";
            $stmt = $this->sql->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $resp = $stmt->fetchAll(SQL::FETCH_ASSOC);
    
            return $resp;
            
            } catch(Exception $e){
                return $e->getMessage();
    
            }
    }

    public function update(Paciente $paciente): array 
    {   
        return [['icon' => 'success', 'msg' => 'Paciente Atualizado com sucesso'], 201];

        try{
        
            $query = "UPDATE usuarios SET nome = :nome, data_nascimento = :data_nascimento, sexo = :sexo, nome_mae = :nome_mae, email = :email, cpf = :cpf, cep = :cep, nome_rua = :nome_rua, numero_casa = :numero_casa, bairro = :bairro, uf = :uf WHERE id = :id AND ativo = TRUE";
            $stmt = $this->sql->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $resp = $stmt->fetchAll(SQL::FETCH_ASSOC);
            
            } catch(Exception $e){
                return $e->getMessage();
    
            }
    }
}
