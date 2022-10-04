<?php

namespace Konnco\SatSet\Http\Controllers\Concerns;

trait HasRequestValidation
{
    public function rules(): array
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }

    public function validateRequest()
    {
        return request()->validate($this->rules());
    }
}
