<?php

namespace App\Machine\Slot;

use App\Machine\Firmware\FirmwareInterface;

class Slots implements FirmwareInterface
{

    public function getSlots(): array
    {
        return [
            'columns' => [
                ['', 'a', 'b']
            ],
            'rows' => [
                ['1', 'Mars', 'Coke'],
                ['2', "M&M's", 'Pepsi'],
            ]
        ];
    }
}