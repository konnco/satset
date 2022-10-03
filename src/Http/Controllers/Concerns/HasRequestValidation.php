<?php

namespace Konnco\SatSet\Http\Controllers\Concerns;

trait HasRequestValidation
{
    public function rules(): array
    {
        return [
            'email' => 'required',
            'password' => 'required',
            'notification_token' => 'nullable',
        ];
    }

    public function validateRequest(): void
    {
        request()->validate($this->rules());
    }
}
