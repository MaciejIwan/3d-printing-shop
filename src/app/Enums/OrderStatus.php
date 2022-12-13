<?php

namespace App\Enums;

enum OrderStatus: string
{
    case New = 'new';
    case Waiting = 'waiting for review';
    case InProgress = 'in progress';
    case Accepted = 'accepted';
    case Done = 'done';
}