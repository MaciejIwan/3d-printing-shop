<?php

namespace App\Enums;

enum UserRole: string
{
    case Newbie = 'newbie';
    case User = 'user';
    case Blocked = 'blocked';
    case Admin = 'admin';
}