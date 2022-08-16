<?php

declare(strict_types=1);

namespace App\Machine;

use App\Machine\Purchase\TransactionInterface as PurchaseTransactionInterface;

interface MachineInterface
{
    /**
     * @param PurchaseTransactionInterface $purchaseTransaction
     * @return void
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction): void;

    /**
     * @return array
     */
    public function loadMachine(): array;
}
