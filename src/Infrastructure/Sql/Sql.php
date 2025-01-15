<?php

namespace App\Infrastructure\Sql;

use \PDO;

class Sql extends PDO
{
    function __construct()
    {
        
        global $env;
        parent::__construct("pgsql:dbname={$env['dbName']};host={$env['dbHost']};port={$env['dbPort']}", $env['dbUser'], $env['dbPass']);

    }
}


