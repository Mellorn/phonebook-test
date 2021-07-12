<?php

declare(strict_types=1);

namespace App\DataTransfer;

use Spatie\DataTransferObject\DataTransferObject;

final class PhoneDTO extends DataTransferObject
{
    public string $number;
}
