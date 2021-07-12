<?php

declare(strict_types=1);

namespace App\Http\Requests\Traits;

trait HasPhoneRules
{
    /**
     * Get phone rules.
     *
     * @return array
     */
    private function phoneRules(): array
    {
        return [
            'bail', 'required', 'string', 'phone:AUTO',
        ];
    }
}
