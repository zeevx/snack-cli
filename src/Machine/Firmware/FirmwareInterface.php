<?php

declare(strict_types=1);

namespace App\Machine\Firmware;

interface FirmwareInterface
{
    /**
     * @return array
     */
    public function getSlots(): array;
}
