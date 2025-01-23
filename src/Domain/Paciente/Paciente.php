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
    const INVALID_SHORT_NAME = 'O nome do paciente deve ter no mínimo 3 caracteres';
    const INVALID_ID = 'Este paciente não existe no banco de dados';
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
        $pattern = '/^[a-záéíóúâêôãõç ]+$/ui';
        if(!preg_match($pattern, $nome)) throw new Exception(self::INVALID_NAME, 400);

        if(strlen($nome) < 3) throw new Exception(self::INVALID_SHORT_NAME, 400);

        return $nome;       
    }

    private static function sexoValidation(string $sexo){
        if(!preg_match('/^[FM]{1}$/', $sexo)) throw new Exception(self::INVALID_SEXO, 400);
    
        return $sexo;
    }

    private static function idValidation(?int $id) : ?int {
        if(!is_null($id) && $id < 0) throw new Exception(self::INVALID_ID, 400);

        return $id;
    }

    private static function dateValidation(string $data_nascimento, $format = 'd-m-Y'){
        $d = DateTime::createFromFormat($format, $data_nascimento);
        if($d && $d->format($format) != $data_nascimento) throw new Exception(self::INVALID_DATA_NASCIMENTO, 400);

        return $data_nascimento;
    }

    private static function emailValidation(string $email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception(self::INVALID_EMAIL, 400);

        return $email;
    }

    private static function cpfValidation(string $cpf)
    {
        $pattern = '/^\d{3}\.?\d{3}\.?\d{3}\-?\d{2}$/';

        if(!preg_match($pattern, $cpf)) throw new Exception(self::INVALID_CPF, 400);

        $cpf = preg_replace('/[.-]/', '', $cpf);

        return $cpf;
    }

    private static function cepValidation(string $cep){
        $pattern = '/^\d{5}-?\d{3}$/';
        
        if(!preg_match($pattern, $cep)) throw new Exception(self::INVALID_CEP, 400);

        $cep = preg_replace('/-/','',$cep);

        return $cep;
    }

    private static function nomeRuaValidation(string $nome_rua){
        $pattern = '/^[a-z,á,é,í,ó,ú,â,ê,ô,ã,õ,ç,.0-9 ]{3,255}$/ui';
        if(!preg_match($pattern, $nome_rua)) throw new Exception(self::INVALID_NOME_RUA, 400);

        return $nome_rua;
    }

    private static function numeroCasaValidation(string $numero_casa)
    {
        $pattern = '/^\d{1,5}$/';
        if(!preg_match($pattern, $numero_casa)) throw new Exception(self::INVALID_NUMERO_CASA, 400);

        return $numero_casa;
    }

    private static function bairroValidation(string $bairro){
        $pattern = '/^[a-z,á,é,í,ó,ú,â,ê,ô,ã,õ,ç,. ]{3,}$/ui';
        if(!preg_match($pattern, $bairro)) throw new Exception(self::INVALID_BAIRRO, 400);

        return $bairro;
    }

    private static function ufValidation(string $uf)
    {
        $arrayUf = ["AC" ,"AL" ,"AP" ,"AM" ,"BA" ,"CE" ,"DF" ,"ES" ,"GO" ,"MA" ,"MT" ,"MS" ,"MG" ,"PA" ,"PB" ,"PR" ,"PE" ,"PI" ,"RJ" ,"RN" ,"RS" ,"RO" ,"RR" ,"SC" ,"SP" ,"SE" ,"TO"];
        if(!in_array($uf, $arrayUf)) throw new Exception(self::INVALID_UF, 400);

        return $uf;
    }

    private static function ativoValidation(bool $ativo)
    {
        if(!is_bool($ativo)) throw new Exception(self::INVALID_ATIVO, 400);

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
