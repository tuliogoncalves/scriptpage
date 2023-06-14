<?php

namespace Scriptpage\Repository;

use Exception;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as IValidationValidator;
use Scriptpage\Repository\Rules;

trait traitCrud
{
    protected array $messages = [];
    protected array $customAttributes = [];
    protected $storeClass;
    protected $validator;

    public function makeModel()
    {
        $this->model = new $this->modelClass;
        return $this->model;
    }

    function getKey()
    {
        return $this->model->getKey();
    }

    /**
     * validate
     *
     * @return Validator
     */
    final protected function validate(string $rule = null, array $attributes, array $messages, array $customAttributes): IValidationValidator
    {
        $validation = is_null($rule)
            ? $this->validator
            : $this->validator[$rule] ?? null;

        $validator = Validator::make(
            $attributes,
            $validation,
            $this->messages,
            $this->customAttributes
        );

        return $validator;
    }

    /**
     * create a new instance
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes = []): Model
    {
        return $this->model->newInstance()->forceFill($attributes);
    }

    /**
     * Summary of store
     * @param array $attributes
     * @param string $rule
     * @return array|\Illuminate\Database\Eloquent\Model
     */
    public function store(array $attributes = [], string $rule = Rules::CREATE): array|Model
    {
        $rules = null;

        if (isset($this->storeClass)) {
            $store = new $this->storeClass;
            $x = $store->validateResolved();
            $rules = $store->rules();
        } else {
            $rules = is_null($rule)
                ? $this->validator
                : $this->validator[$rule] ?? null;
        }

        if (!is_null($rules)) {
            $validator = Validator::make(
                $attributes,
                $rules,
                $this->messages,
                $this->customAttributes
            );

            // dd($attributes, $rules, $validator->fails(), $validator->errors()->toArray());

            if ($validator->fails())
                return $this->response(
                    'the server cannot or will not process the request due to something that is perceived to be a client error',
                    $validator->errors()->toArray(),
                    $code = 400
                );
        }

        try {
            $newInstance = $this->create($attributes);
            $newInstance->save();
            return $newInstance;
        } catch (Exception $e) {
            return $this->response(
                $e->getMessage() . '.Error code:' . $e->getCode(),
                $errors = [],
                $code = 500
            );
        }
    }

    public function save(array $attributes = [], string $rule = Rules::CREATE): array|Model
    {
        return $this->store($attributes, $rule);
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

    public function delete($key): bool
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
}