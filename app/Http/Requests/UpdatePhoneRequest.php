<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Unique;

class UpdatePhoneRequest extends AbstractPhoneRequest
{
    /**
     * Make unique rule.
     *
     * @return Unique
     */
    protected function uniqueRule(): Unique
    {
        return parent::uniqueRule()->ignore($this->route('phone'));
    }
}
