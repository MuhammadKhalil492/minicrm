<?php

namespace App\Enums;

enum RoleEnum: string
{
    // case SuperAdmin = 'super_admin';
    case ADMIN = 'admin';
    case USER = 'user';
    case GUEST = 'guest';
}
