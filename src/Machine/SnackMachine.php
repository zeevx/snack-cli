<?php

declare(strict_types=1);

namespace App\Machine;

use App\Machine\Firmware\FirmwareInterface;
use App\Machine\Purchase\TransactionInterface as PurchaseTransactionInterface;

class SnackMachine implements MachineInterface
{
    private FirmwareInterface $firmaware;
    private string $snackName;
    private float $amountSpent;
    private array $change;

    /**
     * @param FirmwareInterface $firmware
     */
    public function __construct(FirmwareInterface $firmware)
    {
        $this->firmaware = $firmware;
    }

    /**
     * @return array
     */
    public function loadMachine(): array
    {
        return $this->firmaware->getSlots();
    }

    /**
     * @param  string $snackName
     * @return void
     */
    public function setSnackName(string $snackName)
    {
        $this->snackName = $snackName;
    }

    /**
     * @param  float $amountSpent
     * @return void
     */
    public function setAmountSpent(float $amountSpent)
    {
        $this->amountSpent = $amountSpent;
    }

    /**
     * @param  array $change
     * @return void
     */
    public function setChange(array $change)
    {
        $this->change = $change;
    }

    /**
     * @return string
     */
    public function getSnackName(): string
    {
        return $this->snackName;
    }

    /**
     * @return float
     */
    public function getAmountSpent(): float
    {
        return $this->amountSpent;
    }

    /**
     * @return array
     */
    public function getChange(): array
    {
        return $this->change;
    }

    /**
     * @param  PurchaseTransactionInterface $purchaseTransaction
     * @return void
     * @throws \Exception
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction): void
    {
        $pricePerPack = $purchaseTransaction->getPricePerSnack();
        $snacks = $this->loadMachine();

        $snack = $purchaseTransaction->getSnack();
        $snack = str_split($snack);
        if (count($snack) != 2) {
            throw new \Exception("Stock column or row is missing.");
        }

        $quantity = $purchaseTransaction->getQuantity();
        if (! $quantity) {
            throw new \Exception("Snack quantity is required.");
        }

        $paidAmount = $purchaseTransaction->getPaidAmount();
        if (! $paidAmount) {
            throw new \Exception("Amount is required.");
        }

        $column = $snack[1];
        $row = $snack[0];
        $snack_columns = $snacks['columns'][0];
        $snack_rows = $snacks['rows'];

        $column_key = array_search($column, $snack_columns);
        if (! $column_key) {
            throw new \Exception("Snack not found, check the column used.");
        }


        $row_key = array_search($row, array_column($snack_rows, 0));
        if (! $row_key && $row_key !== 0) {
            throw new \Exception("Snack not found, check the row used.");
        }

        $validAmounts = [5,10,20,50];
        if (! in_array($paidAmount, $validAmounts)) {
            $validAmounts = implode(',', $validAmounts);
            throw new \Exception("Invalid amount of money used, you can only use: {$validAmounts}");
        }


        $calculatedAmountSpent = $pricePerPack * $quantity;
        if ($paidAmount < $calculatedAmountSpent) {
            throw new \Exception("You do not have enough money for this snack.");
        }

        $changeAmount = $paidAmount - $calculatedAmountSpent;
        $validCoins = [0.01, 0.02, 0.05, 0.10, 0.20, 0.50, 1.00, 2.00];
        $validCoins = array_reverse($validCoins);
        $changeCoins = [];
        foreach ($validCoins as $coin){
            $remainder = fmod($changeAmount, $coin);
            $count = ($changeAmount - $remainder)/$coin;
            if ($count > 0) {
                $changeCoins[] = [$coin, $count];
            }
            $changeAmount = round($remainder, 2);
        }
        $this->setSnackName($snack_rows[$row_key][$column_key]);
        $this->setAmountSpent($calculatedAmountSpent);
        $this->setChange($changeCoins);
    }
}
