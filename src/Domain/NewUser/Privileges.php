<?php

declare(strict_types=1);

namespace App\Domain\NewUser;

enum Privileges : string
{
    case SuperAdmin = 'super admin';
    case Admin = 'admin';
    case User = 'usuario';
}