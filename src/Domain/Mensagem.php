<?php

namespace App\Domain;

use Slim\Psr7\Response;

class Mensagem
{
 public static function response(string $icon, string $msg, int $statusCode) : array{
    return [['icon' => $icon, 'msg' => $msg], $statusCode] ;

 }
}
