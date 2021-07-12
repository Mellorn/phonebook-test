<?php

declare(strict_types=1);

namespace App\DataTransfer;

use Spatie\DataTransferObject\DataTransferObject;

final class ContactDTO extends DataTransferObject
{
    public string $name;
    public ?PhoneDTO $phone = null;
}
