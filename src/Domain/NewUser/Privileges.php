<?php

declare(strict_types=1);

namespace App\Domain\NewUser;

enum Privileges : string
{
    case SuperAdmin = 'Super Admin';
    case Admin = 'Admin';
    case User = 'User';
}