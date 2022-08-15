<?php

declare(strict_types=1);

namespace App\Machine;

use App\Machine\Firmware\FirmwareInterface;
use App\Machine\Purchase\TransactionInterface as PurchaseTransactionInterface;

class SnackMachine implements MachineInterface
{
    public function __construct(FirmwareInterface $firmware)
    {

    }

    public function loadMachine()
    {

    }

    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        // TODO
    }
}
