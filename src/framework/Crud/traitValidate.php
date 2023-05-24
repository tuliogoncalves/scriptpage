<?php

namespace App\Scriptpage\Crud;

use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;

trait traitValidate
{
    /**
     * validate
     *
     * @return Validator
     */
    final function validate(): ValidationValidator
    {
        $validator = Validator::make(
            $this->all(),
            $this->setDataValidation(),
            $this->messages,
            $this->customAttributes
        );

        return $validator;
    }


    /**
     * set data for validating
     *
     * @return array of data.
     */
    protected function setDataValidation(): array
    {
        return array();
    }


    /**
     * set data for saving
     *
     * @param array $data
     * @return void
     */
    protected function setDataPayload(array $data)
    {
    }


    /**
     * set data for saving
     *
     * @param array $data
     * @return void
     */
    protected function setStoreDataPayload(array $data)
    {
    }
}
