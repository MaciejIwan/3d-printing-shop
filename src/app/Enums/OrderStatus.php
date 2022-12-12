<?php

namespace App\Enums;

enum OrderStatus: string
{
    case NewOrder = 'new';
    case Waiting = 'waiting for review';
    case InProgress = 'in progress';
    case Accepted = 'accepted';
    case Done = 'head';
}