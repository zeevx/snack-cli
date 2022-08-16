<?php

namespace App\Machine\Slot;

use App\Machine\Purchase\TransactionInterface;

class Purchase implements TransactionInterface
{

    private float $paidAmount;
    private int $quantity;
    private float $pricePerSnack;
    private string $snack;

    public function __construct(string $snack, float $paidAmount, int $quantity, float $pricePerSnack)
    {
        $this->snack = $snack;
        $this->paidAmount = $paidAmount;
        $this->quantity = $quantity;
        $this->pricePerSnack = $pricePerSnack;
    }

    public function getPaidAmount(): float
    {
        return $this->paidAmount;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPricePerSnack(): float
    {
        return $this->pricePerSnack;
    }

    public function getSnack(): string
    {
        return $this->snack;
    }
}