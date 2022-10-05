<?php

namespace Konnco\SatSet\Http\Controllers\Concerns;

use Illuminate\Validation\ValidationException;
use Throwable;
use Validator;

trait HasRequestValidation
{
    public function rules(): array
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }

    /**
     * @throws Throwable
     */
    public function validateRequest()
    {
        $validator = Validator::make(request()->all(), $this->rules());

        throw_if(
            $validator->fails(),
            new ValidationException($validator)
        );
    }
}
