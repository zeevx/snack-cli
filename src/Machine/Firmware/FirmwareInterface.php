<?php

declare(strict_types=1);

namespace App\Machine\Firmware;

interface FirmwareInterface
{
    public function getSlots(): array;
}
