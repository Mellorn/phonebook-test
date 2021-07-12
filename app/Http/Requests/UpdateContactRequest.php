<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DataTransfer\ContactDTO;

class UpdateContactRequest extends AbstractContactRequest
{
    /**
     * Get data transfer object with payload.
     *
     * @return ContactDTO
     */
    public function dataTransferObject(): ContactDTO
    {
        return new ContactDTO(
            name: $this->name,
        );
    }
}
