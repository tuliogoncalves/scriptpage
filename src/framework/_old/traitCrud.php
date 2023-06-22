<?php

/*
 * This file is part of scriptpage framework.
 *
 * (c) Túlio Gonçalves <tuliogoncalves@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scriptpage\Repository\Crud;

use Exception;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as IValidator;

trait traitCrud
{
    protected array $messages = [];
    protected array $attributes = [];
    protected $storeClass;

    protected $validator;
    private Validation $validation;

    public function makeValidation(string $class)
    {
        $this->validation = new $class;
        return $this->validation;
    }

    /**
     * validate
     *
     * @return IValidator
     */
    protected function createValidator(array $data, array $rules, array $messages=[], array $attributes =[])
    {
        $validator = Validator::make(
            $data,
            $rules,
            $messages,
            $attributes
        )->stopOnFirstFailure(false);

        return $validator;
    }

    /**
     * create a new instance
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data = [])
    {
        return $this->model->newInstance()->forceFill($data);
    }

    /**
     * Summary of store
     * @param array $attributes
     * @param string $rule
     * @return Model
     */
    public function store(array $data = [])
    {
        if (isset($this->storeClass)) {
            $validation = $this->makeValidation($this->storeClass);
        } else {
            $validation = $this;
        }

        if (!$validation->passesAuthorization()) {
            $validation->failedAuthorization();
        }

        $validator = $this->createValidator(
            $data,
            $validation->getRules(),
            $messages,
            $attributes
        );

        if (!is_null($rules)) {


            if ($validator->fails())
                return $this->baseResponse(
                    'the server cannot or will not process the request due to something that is perceived to be a client error',
                    $validator->errors()->toArray(),
                    $code = 400
                );
        }

        try {
            $newInstance = $this->create($data);
            $newInstance->save();
            return $newInstance;
        } catch (Exception $e) {
            return $this->baseResponse(
                $e->getMessage() . '.Error code:' . $e->getCode(),
                $errors = [],
                $code = 500
            );
        }
    }

    public function save(array $data = [])
    {
        return $this->store($data);
    }

    public function update()
    {
        $obj = $this->object;
        $this->setDataPayload($this->all());
        $obj->fill($this->all());
        $obj->save();
        return $obj;

        ###
        # l5-repository
        ###
        $this->applyScope();

        if (!is_null($this->validator)) {
            // we should pass data that has been casts by the model
            // to make sure data type are same because validator may need to use
            // this data to compare with data that fetch from database.
            $model = $this->model->newInstance();
            $model->setRawAttributes([]);
            $model->setAppends([]);
            $attributes = $model->forceFill($attributes)->makeVisible($this->model->getHidden())->toArray();

            $this->validator->with($attributes)->setId($id)->passesOrFail(ValidatorInterface::RULE_UPDATE);
        }

        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        $model = $this->model->findOrFail($id);

        $model->fill($attributes);
        $model->save();

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        event(new RepositoryEntityUpdated($this, $model));

        return $this->parserResult($model);
    }

    public function delete($key)
    {
        return $this->model->destroy($key);
    }

    public function updateOrCreate(array $attributes, array $values = [])
    {
        $this->applyScope();

        if (!is_null($this->validator)) {
            $this->validator->with(array_merge($attributes, $values))->passesOrFail(ValidatorInterface::RULE_CREATE);
        }

        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        event(new RepositoryEntityCreating($this, $attributes));

        $model = $this->model->updateOrCreate($attributes, $values);

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        event(new RepositoryEntityUpdated($this, $model));

        return $this->parserResult($model);
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
}