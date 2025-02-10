<?php

namespace App\Domain;


class Mensagem
{
 public static function response(string $icon, string $msg, int $statusCode) : array{
    return [['icon' => $icon, 'msg' => $msg], $statusCode] ;

 }
}
