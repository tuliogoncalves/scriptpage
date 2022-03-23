<?php

namespace App\Scriptpage\Repository;

use App\Scriptpage\Contracts\ICrud;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

abstract class Crud
extends BaseRepository
implements ICrud
{
    /**
     * messages
     *
     * @var array
     */
    protected array $messages = [];

    /**
     * data
     *
     * @var array
     */
    protected array $data = [];


    /**
     * setData
     *
     * @param array $data
     * @return void
     */
    public function setData(array $data) {
        $this->data = $data;
    }



    /**
     * create new model.
     *
     * @return Model new model object.
     */
    public function create(): Model
    {
        return $this->model->with($this->with)->getModel()->newInstance();
    }


    /**
     * read
     *
     * @param  mixed $id
     * @return Model object readed from database
     */
    public function read($id): Model
    {
        return $this->model->findOrFail($id);
    }


    /**
     * Create new record in database.
     *
     * @return Model model object with data.
     */
    public function store()
    {
        $obj = $this->create();
        $obj->fill($this->setDataPayload($this->data));
        $obj->save();
        return $obj;
    }


    /**
     * update existing item.
     *
     * @param Integer $id integer item primary key.
     * @return Model updated item object.
     */
    public function update($id)
    {
        $obj = $this->read($id);
        $obj->fill($this->setDataPayload($this->data));
        $obj->save();
        return $obj;
    }


    /**
     * Delete item by primary key id.
     *
     * @param  Integer $id integer of primary key id.
     * @return boolean
     */
    public function delete($id): bool
    {
        return $this->model->destroy($id);
    }


    /**
     * validate
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(): \Illuminate\Contracts\Validation\Validator
    {
        $validator = Validator::make(
            $this->data,
            $this->setDataValidation(),
            $this->messages
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
     * @return array of data.
     */
    protected function setDataPayload(array $data): array
    {
        return array();
    }

    /**
     * getValue
     *
     * @param  mixed $value
     * @return void
     */
    final function getValue($value)
    {
        return $value == 'null' ? null : $value;
    }
}
