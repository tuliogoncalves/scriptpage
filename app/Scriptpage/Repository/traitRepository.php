<?php

namespace App\Scriptpage\Repository;

trait traitRepository
{
    /**
     * Model class for repo.
     *
     * @var string
     */
    protected string $modelClass;


    /**
     * Eloquent model instance.
     */
    protected $model;


    /**
     * with
     *
     * @var array
     */
    protected $with = [];


    /**
     * load default class dependencies.
     *
     * @dependencies Model $model Illuminate\Database\Eloquent\Model
     */
    function __construct()
    {
        if (!empty($this->modelClass)) {
            $this->model = app($this->modelClass);
        }
        $this->init();
    }

    /**
     * Initialization
     */
    function init()
    {
    }


    /**
     * get ID
     *
     * @return mixed
     */
    function getId()
    {
        return $this->model->getKey();
    }


    /**
     * @param Array|String $with
     *
     * @return Repository
     */
    function with($with = [])
    {
        if (is_string($with)) $with = explode(',', $with);
        $this->with = $with;
        return $this;
    }
}
