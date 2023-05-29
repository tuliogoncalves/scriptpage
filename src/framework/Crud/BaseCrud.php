<?php

namespace Scriptpage\Crud;

use Exception;
use Scriptpage\Contracts\ICrud;
use Illuminate\Database\Eloquent\Model;


abstract class BaseCrud
implements ICrud
{
    protected Model $model;
    protected string $modelClass;

    function __construct()
    {
        $this->model = app($this->modelClass);
    }

    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this::class} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * messages
     *
     * @var array
     */
    protected array $messages = [];


    /**
     * customAttributes
     *
     * @var array
     */
    protected array $customAttributes = [];

    /**
     * create new model.
     *
     * @return Model new model object.
     */
    public function create(): Model
    {
        $this->object = $this->model->with($this->with)->getModel()->newInstance();
        return $this->object;

        ###
        # l5-repository
        ###
        if (!is_null($this->validator)) {
            // we should pass data that has been casts by the model
            // to make sure data type are same because validator may need to use
            // this data to compare with data that fetch from database.
            if ($this->versionCompare($this->app->version(), "5.2.*", ">")) {
                $attributes = $this->model->newInstance()->forceFill($attributes)->makeVisible($this->model->getHidden())->toArray();
            } else {
                $model = $this->model->newInstance()->forceFill($attributes);
                $model->makeVisible($this->model->getHidden());
                $attributes = $model->toArray();
            }

            $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
        }

        event(new RepositoryEntityCreating($this, $attributes));

        $model = $this->model->newInstance($attributes);
        $model->save();
        $this->resetModel();

        event(new RepositoryEntityCreated($this, $model));

        return $this->parserResult($model);
    }


    /**
     * getModelKey
     *
     * @return mixed
     */
    function getModelKey()
    {
        return $this->model->getKey();
    }


    /**
     * Create new record in database.
     *
     * @return Model model object with data.
     */
    public function store()
    {
        $this->setDataPayload($this->all());
        $this->setStoreDataPayload($this->all());

        $obj = $this->object;
        $obj->fill($this->all());
        $obj->save();

        $this->key = $obj->getkey();

        return $obj;
    }

    /**
     * update existing item.
     *
     * @param Integer $id integer item primary key.
     * @return Model updated item object.
     */
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
            if ($this->versionCompare($this->app->version(), "5.2.*", ">")) {
                $attributes = $model->forceFill($attributes)->makeVisible($this->model->getHidden())->toArray();
            } else {
                $model->forceFill($attributes);
                $model->makeVisible($this->model->getHidden());
                $attributes = $model->toArray();
            }

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

    /**
     * Delete item by primary key id.
     *
     * @param  Integer $id integer of primary key id.
     * @return boolean
     */
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

    /**
     * Trigger static method calls to the model
     *
     * @param $method
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        return call_user_func_array([new static(), $method], $arguments);
    }

    /**
     * Trigger method calls to the model
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->model, $method], $arguments);
    }
}
