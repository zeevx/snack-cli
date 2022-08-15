<?php

declare(strict_types=1);

namespace App\Machine\Purchase;

interface TransactionInterface
{
    public function getPaidAmount(): float;
}
