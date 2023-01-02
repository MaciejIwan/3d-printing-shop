<?php

namespace App\Enum;

enum UserRole: string
{
    case Newbie = 'newbie';
    case User = 'user';
    case Blocked = 'blocked';
    case Admin = 'admin';
}