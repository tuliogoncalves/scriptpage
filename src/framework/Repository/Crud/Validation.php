<?php

namespace Scriptpage\Repository\Crud;

// use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as IValidator;

abstract class Validation
{
    abstract function rules();

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        //
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    public function passedValidation()
    {
        //
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }

    /**
     * Summary of getRules
     * @return mixed
     */
    public function getRules()
    {
        $rules = method_exists($this, 'rules') ? $this->rules() : [];

        return $rules;
    }

    /**
     * Determine if the request passes the authorization check.
     *
     * @return bool
     */
    function passesAuthorization()
    {
        if (method_exists($this, 'authorize')) {
            return $this->authorize();
        }

        return true;
    }

    /**
     * Get the validator instance for the request.
     *
     * @return IValidator
     */
    protected function getValidatorInstance()
    {
        if ($this->validator) {
            return $this->validator;
        }

        if (method_exists($this, 'validator')) {
            $validator = $this->validator();
        } else {
            $validator = $this->createDefaultValidator();
        }

        if (method_exists($this, 'withValidator')) {
            $this->withValidator($validator);
        }

        if (method_exists($this, 'after')) {
            $validator->after($this->container->call(
                $this->after(...),
                ['validator' => $validator]
            ));
        }

        return $this->validator;
    }
}
