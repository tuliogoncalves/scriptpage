<?php

namespace Scriptpage\Repository\Crud;

// use Illuminate\Foundation\Http\FormRequest;

abstract class Validation
{
    function __construct()
    {
    }

    abstract function rules();
    
    /**
     * Create the default validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Factory $factory
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getRules()
    {
        $rules = method_exists($this, 'rules') ? $this->rules() : [];

        return $rules;
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
}
