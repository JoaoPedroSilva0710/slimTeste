<?php

declare(strict_types=1);

namespace App\Domain\Paciente;

use JsonSerializable;
use App\Domain\Paciente\NameValidation;
use \DateTime;
use \Exception;
use PhpParser\Node\Expr\Exit_;
use PhpParser\Node\Expr\FuncCall;

use function PHPUnit\Framework\throwException;

class Paciente implements JsonSerializable
{
    const INVALID_NAME = 'O nome do paciente ou da mãe é inválido';
    const INVALID_SHORT_NAME = 'O nome do paciente deve ter no mínimo 5 caracteres';
    const INVALID_ID = 'Este usuário não existe no banco de dados';
    const INVALID_SEXO = 'Digite F ou M no campo sexo';
    const INVALID_DATA_NASCIMENTO = 'Digite uma data de nascimento válida';
    const INVALID_EMAIL = 'Este e-mail é inválido';
    const INVALID_CPF = 'Este CPF é inválido';
    const INVALID_CEP = 'Este CEP é inválido';
    const INVALID_NOME_RUA = 'Este nome de rua é inválido';
    const INVALID_NUMERO_CASA = 'Escreva um número de casa válido';
    const INVALID_BAIRRO = 'Escreva um nome de bairro válido';
    const INVALID_UF = 'Escreva um UF que exista no Brasil';
    const INVALID_ATIVO = 'O ativo deve ser do tipo booleano';

    private function __construct(public readonly ?int $id, public readonly string $nome, public readonly string $data_nascimento, public readonly string $sexo, public readonly string $nome_mae, public readonly string $email, public readonly string $cpf, public readonly string $cep, public readonly string $nome_rua, public readonly string $numero_casa, public readonly string $bairro, public readonly string $uf, public readonly bool $ativo){


    }

    public static function create(?int $id, string $nome, string $data_nascimento, string $sexo, string $nome_mae, string $email, string $cpf, string $cep, string $nome_rua, string $numero_casa, string $bairro, string $uf, bool $ativo): self
    {
        return new self(self::idValidation($id), self::nameValidation($nome), self::dateValidation($data_nascimento), self::sexoValidation($sexo), self::nameValidation($nome_mae), self::emailValidation($email), self::cpfValidation($cpf), self::cepValidation($cep),  self::nomeRuaValidation($nome_rua), self::numeroCasaValidation($numero_casa), self::bairroValidation($bairro), self::ufValidation($uf), self::ativoValidation($ativo));
    }

    private static function nameValidation(string $nome){
        $pattern = '/^([a-z,á,é,í,ó,ú,â,ê,ô,ã,õ,ç," "]+)$/ui';
        if (!preg_match($pattern, $nome)){
            throw new Exception(self::INVALID_NAME);
        }

        if(strlen($nome) < 5){
            throw new Exception(self::INVALID_SHORT_NAME);
        }

        return $nome;
        
    }

    private static function sexoValidation(string $sexo){
        if(!$sexo || strlen($sexo) > 1 || !preg_match('/[FM]/', $sexo)){
            throw new Exception(self::INVALID_SEXO);

        }
        
        return $sexo;
    }

    private static function idValidation(?int $id){
        if($id <= 0){
            throw new Exception(self::INVALID_ID);
        }

        return $id;
    }

    private static function dateValidation(string $data_nascimento, $format = 'd-m-Y'){
        $d = DateTime::createFromFormat($format, $data_nascimento);
        if($d && $d->format($format) != $data_nascimento)
        {
            throw new Exception(self::INVALID_DATA_NASCIMENTO);
        }
        return $data_nascimento;

    }

    private static function emailValidation(string $email)
    {
        if(!$email || !filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new Exception(self::INVALID_EMAIL);
        }

        return $email;
    }

    private static function cpfValidation(string $cpf)
    {
        $pattern = '/\d{3}\.?\d{3}\.?\d{3}\-?\d{2}/';
        if(!preg_match($pattern, $cpf))
        {
            throw new Exception(self::INVALID_CPF);
        }
        return $cpf;
    }

    private static function cepValidation(string $cep){
        $pattern = '/\^d{5}-?\d{3}$/';
        if(!preg_match($pattern, $cep)){
            throw new Exception(self::INVALID_CEP);
        }

        return $cep;
    }

    private static function nomeRuaValidation(string $nome_rua){
        $pattern = '/^([a-z,á,é,í,ó,ú,â,ê,ô,ã,õ,ç," "\.0-9]+)$/ui';
        if(!preg_match($nome_rua, $pattern))
        {
            throw new Exception(self::INVALID_NOME_RUA);
        }

        return $nome_rua;
    }

    private static function numeroCasaValidation(string $numero_casa)
    {
        $pattern = '/\d{0,5}/';
        if(!preg_match($pattern, $numero_casa))
        {
            throw new Exception(self::INVALID_NUMERO_CASA);
        }

        return $numero_casa;
    }

    private static function bairroValidation(string $bairro){
        $pattern = '/^([a-z,á,é,í,ó,ú,â,ê,ô,ã,õ,ç," "\.0-9]+)$/ui';
        if(!preg_match($bairro, $pattern))
        {
            throw new Exception(self::INVALID_NOME_RUA);
        }

        return $bairro;
    }

    private static function ufValidation(string $uf)
    {
        $arrayUf = ["AC" ,"AL" ,"AP" ,"AM" ,"BA" ,"CE" ,"DF" ,"ES" ,"GO" ,"MA" ,"MT" ,"MS" ,"MG" ,"PA" ,"PB" ,"PR" ,"PE" ,"PI" ,"RJ" ,"RN" ,"RS" ,"RO" ,"RR" ,"SC" ,"SP" ,"SE" ,"TO"];
        if(!in_array($uf, $arrayUf))
        {
            throw new Exception(self::INVALID_UF);
        }

        return $uf;
    }

    private static function ativoValidation(bool $ativo)
    {
        if(!is_bool($ativo))
        {
            throw new Exception(self::INVALID_ATIVO);
        }

        return $ativo;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'data_nascimento' => $this->data_nascimento,
            'sexo' => $this->sexo,
            'nome_mae' => $this->nome_mae,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'cep' => $this->cep,
            'nome_rua' => $this->nome_rua,
            'numero_casa' => $this->numero_casa,
            'bairro' => $this->bairro,
            'uf' => $this->uf,
            'ativo' => $this->ativo  
        ];
    }

}
