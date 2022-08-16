<?php

namespace App\Machine\Slot;

use App\Machine\Purchase\TransactionInterface;

class Purchase implements TransactionInterface
{

    private float $paidAmount;
    private int $quantity;
    private float $pricePerSnack;
    private string $snack;

    /**
     * @param string $snack
     * @param float  $paidAmount
     * @param int    $quantity
     * @param float  $pricePerSnack
     */
    public function __construct(string $snack, float $paidAmount, int $quantity, float $pricePerSnack)
    {
        $this->snack = $snack;
        $this->paidAmount = $paidAmount;
        $this->quantity = $quantity;
        $this->pricePerSnack = $pricePerSnack;
    }

    /**
     * @return float
     */
    public function getPaidAmount(): float
    {
        return $this->paidAmount;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getPricePerSnack(): float
    {
        return $this->pricePerSnack;
    }

    /**
     * @return string
     */
    public function getSnack(): string
    {
        return $this->snack;
    }
}