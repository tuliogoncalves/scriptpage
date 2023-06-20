<?php

namespace Scriptpage\Repository\Crud;

use Exception;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as IValidator;
use Scriptpage\Repository\Rules;

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
     * @return array|\Illuminate\Database\Eloquent\Model
     */
    public function store(array $data = [], string $rule = Rules::CREATE): array|Model
    {
        $rules = null;
        $store = null;

        if (isset($this->storeClass)) {
            $store = $this->makeValidation($this->storeClass);
            $rules = $store->getRules();
        } else {
            $rules = is_null($rule)
                ? $this->validator
                : $this->validator[$rule] ?? null;
            $messages = $this->messages;
            $attributes = $this->attributes;
        }

        if(isset($store)) {
            if(!$store->passesAuthorization()) {
                return $this->baseResponse(
                    'filed Authorization to store crud',
                    [],
                    $code = 403
                );                
            }
        }

        if (!is_null($rules)) {
            $validator = $this->createValidator(
                $data,
                $rules,
                $messages,
                $attributes
            );

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

    public function save(array $data = [], string $rule = Rules::CREATE): array|Model
    {
        return $this->store($data, $rule);
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