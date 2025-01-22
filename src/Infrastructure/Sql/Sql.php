<?php

namespace App\Infrastructure\Sql;

use App\Domain\Mensagem;
use Exception;
use \PDO;
use PhpParser\Node\Expr\Throw_;

class Sql extends PDO
{
    const IMPOSSIBLE_CREATE_CONNECTION = 'Não foi possível criar a conexão com o Banco de dados';

    function __construct()
    {
        
        global $env;
        try {
            parent::__construct("pgsql:dbname={$env['dbName']};host={$env['dbHost']};port={$env['dbPort']}", $env['dbUser'], $env['dbPass']);

        } catch (Exception $e) {
            Throw new Exception(self::IMPOSSIBLE_CREATE_CONNECTION, 400);
        }

    }
}


