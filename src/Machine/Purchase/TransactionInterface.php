<?php

declare(strict_types=1);

namespace App\Machine\Purchase;

interface TransactionInterface
{
    /**
     * @return float
     */
    public function getPaidAmount(): float;

    /**
     * @return int
     */
    public function getQuantity(): int;

    /**
     * @return float
     */
    public function getPricePerSnack(): float;

    /**
     * @return string
     */
    public function getSnack(): string;
}
