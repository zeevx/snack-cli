<?php

declare(strict_types=1);

namespace App\Machine;

use App\Machine\Firmware\FirmwareInterface;
use App\Machine\Purchase\TransactionInterface as PurchaseTransactionInterface;

class SnackMachine implements MachineInterface
{
    private FirmwareInterface $firmaware;

    public function __construct(FirmwareInterface $firmware)
    {
        $this->firmaware = $firmware;
    }

    public function loadMachine(): array
    {
        return $this->firmaware->getSlots();
    }

    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        // TODO
    }
}
