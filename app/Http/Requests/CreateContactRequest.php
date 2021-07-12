<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DataTransfer\ContactDTO;

class CreateContactRequest extends AbstractContactRequest
{
    use Traits\HasPhoneRules;

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData(): array
    {
        return parent::validationData() + $this->only(['phone']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return parent::rules() + ['phone' => $this->phoneRules()];
    }

    /**
     * Get data transfer object with payload.
     *
     * @return ContactDTO
     */
    public function dataTransferObject(): ContactDTO
    {
        return new ContactDTO(
            name: $this->name,
            phone: ['number' => $this->phone]
        );
    }
}
