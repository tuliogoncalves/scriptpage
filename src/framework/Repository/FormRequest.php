<?php

namespace Scriptpage\Repository;

use Illuminate\Foundation\Http\FormRequest;

class FormRequestX extends FormRequest
{
    protected function getValidatorInstance()
    {
        if ($this->validator) {
            return $this->validator;
        }

        $factory = $this->container->make(ValidationFactory::class);

        if (method_exists($this, 'validator')) {
            $validator = $this->container->call([$this, 'validator'], compact('factory'));
        } else {
            $validator = $this->createDefaultValidator($factory);
        }

        if (method_exists($this, 'withValidator')) {
            $this->withValidator($validator);
        }

        if (method_exists($this, 'after')) {
            $validator->after($this->container->call(
                $this->after(...),
                ['validator' => $validator]
            )
            );
        }

        $this->setValidator($validator);

        return $this->validator;
    }

    /**
     * Create the default validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Factory  $factory
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createDefaultValidator(ValidationFactory $factory)
    {
        $rules = method_exists($this, 'rules') ? $this->container->call([$this, 'rules']) : [];

        $validator = $factory->make(
            $this->validationData(),
            $rules,
            $this->messages(), $this->attributes()
        )->stopOnFirstFailure($this->stopOnFirstFailure);

        if ($this->isPrecognitive()) {
            $validator->setRules(
                $this->filterPrecognitiveRules($validator->getRulesWithoutPlaceholders())
            );
        }

        return $validator;
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