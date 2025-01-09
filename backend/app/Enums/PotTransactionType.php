<?php

declare(strict_types=1);

namespace App\Enums;

enum PotTransactionType: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAW = 'withdraw';
}
