<?php

declare(strict_types=1);

namespace App\Machine;

use App\Machine\Purchase\TransactionInterface as PurchaseTransactionInterface;

interface MachineInterface
{
    public function execute(PurchaseTransactionInterface $purchaseTransaction);
    public function loadMachine();
}
