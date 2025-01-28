<?php

namespace App\Infrastructure\Sql;

use App\Domain\Mensagem;
use Exception;
use \PDO;
use PhpParser\Node\Expr\Throw_;

class Sql extends PDO
{
    const BD_ERRORS = 'Há algum erro na aplicação, caso o erro persistir procure os administradores';

    function __construct()
    {
        
        global $env;
        try {
            parent::__construct("pgsql:dbname={$env['dbName']};host={$env['dbHost']};port={$env['dbPort']}", $env['dbUser'], $env['dbPass']);

        } catch (Exception $e) {
            return Mensagem::response('error', self::BD_ERRORS, 400);
        }

    }
}


