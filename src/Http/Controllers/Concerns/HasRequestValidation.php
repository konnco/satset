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

    public function validateRequest()
    {
        return request()->validate($this->rules());
    }
}
