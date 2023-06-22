<?php

/*
 * This file is part of scriptpage framework.
 *
 * (c) Túlio Gonçalves <tuliogoncalves@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scriptpage\Assets;

use Scriptpage\Exceptions\AuthorizationException;
use Scriptpage\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator as IValidator;

trait traitValidation
{
    private $dataPayload = [];
    protected array $messages = [];
    protected array $attributes = [];
    protected $storeClass;

    public function authorize()
    {
        return true;
    }

    /**
     * Set data Payload
     *
     * @param array $data
     * @return void
     */
    public function setDataPayload(array $data)
    {
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

    public function withValidator(IValidator $validator)
    {
        return true;
    }

    /**
     * Get data Payload
     * @return array
     */
    public function getDataPayload()
    {
        return $this->dataPayload;
    }

    /**
     * Summary of getRules
     * @return array
     */
    public function getRules()
    {
        $rules = $this->rules() ?? [];

        return $rules;
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException(null, $code = 403);
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws ValidationException
     */
    protected function failedValidation($message = '', $errors = [], $code = 400)
    {
        throw new ValidationException($message, $code, $errors);
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws ValidationException
     */
    protected function failedRepository($message = '', $errors = [], $code = 500)
    {
        throw new ValidationException($message, $code, $errors);
    }

    /**
     * Dynamically retrieve attributes on the repository.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->dataPayload[$key] ?? null;
    }

    /**
     * Trigger method calls to the attributes repository.
     * @param mixed $key
     * @param mixed $value
     * @return self
     */
    public function __set($key, $value)
    {
        $this->dataPayload[$key] = $value;
        return $this;
    }
}