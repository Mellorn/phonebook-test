<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use App\Models\Phone;
use App\DataTransfer\PhoneDTO;

abstract class AbstractPhoneRequest extends FormRequest
{
    use Traits\HasPhoneRules;

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData(): array
    {
        return $this->only(['phone']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'phone' => [
                ...$this->phoneRules(),
                $this->uniqueRule(),
            ],
        ];
    }

    /**
     * Make unique rule.
     *
     * @return Unique
     */
    protected function uniqueRule(): Unique
    {
        return (new Unique(Phone::class, 'number'))
            ->where('contact_id', $this->route('contact')->getKey());
    }

    /**
     * Get data transfer object with payload.
     *
     * @return PhoneDTO
     */
    public function dataTransferObject(): PhoneDTO
    {
        return new PhoneDTO(
            number: $this->phone
        );
    }
}
