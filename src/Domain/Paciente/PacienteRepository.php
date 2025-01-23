<?php

declare(strict_types=1);

namespace App\Domain\Paciente;

use App\Domain\Mensagem;
use Exception;
use App\Infrastructure\Sql\Sql;
use PDO;

class PacienteRepository implements PacienteRepositoryInterface
{
    const PACIENT_NOT_FOUND = 'O paciente não foi encontrado';
    const PACIENT_UPDATED = 'Paciente Atualizado com sucesso';
    const PACIENT_CREATED = 'Paciente Criado com sucesso';
    const PACIENT_DELETED = 'Paciente Deletado com sucesso';

    public function __construct(protected Sql $sql)
    {
        
    }


    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        try {

        $query = "SELECT * FROM pacientes where ativo = TRUE";
        $stmt = $this->sql->prepare($query);
        $stmt->execute();
        $resp = $stmt->fetchAll(SQL::FETCH_ASSOC);
        
        return $resp;

        } catch(Exception $e) {
            return Mensagem::response('error', $e->getMessage(), $e->getCode());
        }
    }


    /**
     * {@inheritdoc}
     */
    public function findPacienteOfId(int $id): array
    {
        try{
        
        $query = "SELECT * FROM pacientes WHERE id = :id AND ativo = TRUE;";
        $stmt = $this->sql->prepare($query);

        $stmt->bindValue(":id", $id);
        
        $stmt->execute();

        $resp = $stmt->fetchAll(SQL::FETCH_ASSOC);

        return $resp;
        
        } catch(Exception $e){
            return Mensagem::response('error', $e->getMessage(), $e->getCode());

        }
    }


    public function cadastrate(Paciente $paciente): array
    {
        try{

            $query = "INSERT INTO pacientes (nome, data_nascimento, sexo, nome_mae, email, cpf, cep, nome_rua, numero_casa, bairro, uf) VALUES ( :nome, :data_nascimento, :sexo, :nome_mae, :email, :cpf, :cep, :nome_rua, :numero_casa, :bairro, :uf);";

            $stmt = $this->sql->prepare($query);

            $stmt->bindValue(":nome", $paciente->nome);
            $stmt->bindValue(":data_nascimento", $paciente->data_nascimento);
            $stmt->bindValue(":sexo", $paciente->sexo);
            $stmt->bindValue(":nome_mae", $paciente->nome_mae);
            $stmt->bindValue(":email", $paciente->email);
            $stmt->bindValue(":cpf", $paciente->cpf);
            $stmt->bindValue(":cep", $paciente->cep);
            $stmt->bindValue(":nome_rua", $paciente->nome_rua);
            $stmt->bindValue(":numero_casa", $paciente->numero_casa);
            $stmt->bindValue(":bairro", $paciente->bairro);
            $stmt->bindValue(":uf", $paciente->uf);

            $stmt->execute();
    
            return Mensagem::response('success', self::PACIENT_CREATED, 201);
            
            } catch(Exception $e){
                return Mensagem::response('error', $e->getMessage(), $e->getCode());
    
            }
    }


    public function delete(int $id): array
    {
        try{
        
            $query = "UPDATE pacientes SET ativo = false where id = :id";

            $stmt = $this->sql->prepare($query);
            $stmt->bindValue(":id", $id);
            $stmt->execute();

    
            return Mensagem::response('success', self::PACIENT_DELETED, 201);
            
            } catch(Exception $e){
                return Mensagem::response('error', $e->getMessage(), $e->getCode());
    
            }
    }


    public function update(Paciente $paciente): array 
    {   
        
        try{
            
            $query = "UPDATE pacientes SET nome = :nome, data_nascimento = :data_nascimento, sexo = :sexo, nome_mae = :nome_mae, email = :email, cpf = :cpf, cep = :cep, nome_rua = :nome_rua, numero_casa = :numero_casa, bairro = :bairro, uf = :uf WHERE id = :id AND ativo = TRUE;";
            
            $stmt = $this->sql->prepare($query);
            
            $stmt->bindValue(":id", $paciente->id);
            $stmt->bindValue(":nome", $paciente->nome);
            $stmt->bindValue(":data_nascimento", $paciente->data_nascimento);
            $stmt->bindValue(":sexo", $paciente->sexo);
            $stmt->bindValue(":nome_mae", $paciente->nome_mae);
            $stmt->bindValue(":email", $paciente->email);
            $stmt->bindValue(":cpf", $paciente->cpf);
            $stmt->bindValue(":cep", $paciente->cep);
            $stmt->bindValue(":nome_rua", $paciente->nome_rua);
            $stmt->bindValue(":numero_casa", $paciente->numero_casa);
            $stmt->bindValue(":bairro", $paciente->bairro);
            $stmt->bindValue(":uf", $paciente->uf);
            
            $stmt->execute();
           
            return Mensagem::response('success', self::PACIENT_UPDATED, 201);
            
        } catch(Exception $e){

            return Mensagem::response('error', $e->getMessage(), $e->getCode());
            
        }

    }
}
