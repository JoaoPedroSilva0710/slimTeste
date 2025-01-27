<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\NewUser;

use Exception;
use App\Domain\Mensagem;
use App\Domain\NewUser\User;
use App\Infrastructure\Sql\Sql;
use App\Domain\NewUser\UserNotFoundException;
use App\Domain\NewUser\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    const USER_NOT_FOUND = 'O usuário não foi encontrado';
    const USER_UPDATED = 'Usuário Atualizado com sucesso';
    const USER_CREATED = 'Usuário Criado com sucesso';
    const USER_DELETED = 'Usuário Deletado com sucesso';
    const USER_INACTIVATED = 'Usuário Inativado com sucesso';

        /**
     * @var User[]
     */
    private array $users;

    /**
     * @param User[]|null $users
     */
    public function __construct(protected Sql $sql)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        try {

            $query = "SELECT name, cpf, email, active, privileges FROM users where active = TRUE;";

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
    public function findUserOfId(int $id): array
    {
        try{
        
            $query = "SELECT name, cpf, email, active, privileges FROM users WHERE id = :id AND active = TRUE;";
            $stmt = $this->sql->prepare($query);
    
            $stmt->bindValue(":id", $id);
            
            $stmt->execute();
    
            $resp = $stmt->fetchAll(SQL::FETCH_ASSOC);
    
            return $resp;
            
            } catch(Exception $e){
                return Mensagem::response('error', $e->getMessage(), $e->getCode());
    
            }
    }

    public function cadastrate(User $user): array
    {
        try{
            $query = "INSERT INTO users	(name, cpf, email, password, privileges, active) VALUES (:name, :cpf, :email, :password, :privileges, :active);";

            $stmt = $this->sql->prepare($query);

            $stmt->bindValue(":name", $user->name);
            $stmt->bindValue(":cpf", $user->cpf);
            $stmt->bindValue(":email", $user->email);
            $stmt->bindValue(":password", $user->password);
            $stmt->bindValue(":privileges", $user->privileges->value);
            $stmt->bindValue(":active", $user->active);

            $stmt->execute();
    
            return Mensagem::response('success', self::USER_CREATED, 201);
            
            } catch(Exception $e){
                return Mensagem::response('error', $e->getMessage(), $e->getCode());
    
            }
    }


    public function inactive(int $id): array
    {
        try{
        
            $query = "UPDATE users SET active = false where id = :id";

            $stmt = $this->sql->prepare($query);
            $stmt->bindValue(":id", $id);
            $stmt->execute();

    
            return Mensagem::response('success', self::USER_INACTIVATED, 201);
            
            } catch(Exception $e){
                return Mensagem::response('error', $e->getMessage(), $e->getCode());
    
            }
    }


    public function update(User $user): array 
    {   
        
        try{
            
            $query = "UPDATE users SET email = :email, password = :password, name = :name, cpf = :cpf, privileges = :privileges, active = :active WHERE id = :id;";
            
            $stmt = $this->sql->prepare($query);
            
            $stmt->bindValue(":nome", $user->id);
            $stmt->bindValue(":data_nascimento", $user->email);
            $stmt->bindValue(":sexo", $user->password);
            $stmt->bindValue(":nome_mae", $user->name);
            $stmt->bindValue(":email", $user->cpf);
            $stmt->bindValue(":cpf", $user->privileges);
            $stmt->bindValue(":cep", $user->active);
            
            $stmt->execute();
           
            return Mensagem::response('success', self::USER_UPDATED, 201);
            
        } catch(Exception $e){

            return Mensagem::response('error', $e->getMessage(), $e->getCode());
            
        }

    }

    public function delete(int $id): array 
    {
        $query = "UPDATE users SET date_deleted = :date_deleted";
        
        $stmt = $this->sql->prepare($query);
        $stmt->bindValue(':date_deleted', date('Y-m-d'));

        try {
            $stmt->execute();
        } catch (\Throwable $th) {
            return Mensagem::response('error', $th->getMessage(), $th->getCode());
        }

        return Mensagem::response('success', self::USER_DELETED, 201);
    }

    public function login(string $email, string $passwd)
    {
        try{
        
            $query = "SELECT name, cpf, email, active, privileges FROM users WHERE email = :email AND active = TRUE;";
            $stmt = $this->sql->prepare($query);
    
            $stmt->bindValue(":email", $email);
            
            $stmt->execute();
    
            $resp = $stmt->fetch(Sql::FETCH_ASSOC);

            
    
            return $resp;
            
            } catch(Exception $e){
                return Mensagem::response('error', $e->getMessage(), $e->getCode());
    
            }
    }

    private function verifypasswd(?string $passwd, ?string $resp) 
    {
        if(!password_verify($passwd, $resp['password'])){
            header("Location: ../index.php");
        }
        
        session_start();
        $_SESSION["user"] = $resp['name'];
    }
}