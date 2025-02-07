<?php

namespace App\Infrastructure\Sql;

use App\Domain\Mensagem;
use Exception;
use \PDO;
use PhpParser\Node\Expr\Throw_;
use Psr\Log\LoggerInterface;

class Sql extends PDO
{
    const BD_ERRORS = 'Há algum erro na aplicação, caso o erro persistir procure os administradores';

    function __construct(protected LoggerInterface $logger)
    {
        
        global $env;
        try {
            parent::__construct("pgsql:dbname={$env['postgres']['name']};host={$env['postgres']['host']};port={$env['postgres']['port']}", $env['postgres']['user'], $env['postgres']['password']);

        } catch (Exception $e) {
            $this->logger->critical($e->getMessage(), ['Exception' => $e]);
            
            return Mensagem::response('error', self::BD_ERRORS, 400);
        }

    }
}


