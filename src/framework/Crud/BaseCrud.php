<?php

namespace Scriptpage\Crud;

use Scriptpage\Contracts\ICrud;
use Illuminate\Database\Eloquent\Model;
use Scriptpage\Contracts\traitActionable;
use Scriptpage\Contracts\traitWithAttributes;
use Scriptpage\Repository\traitRepository;

abstract class BaseCrud
implements ICrud
{
    use traitValidate;
    use traitRepository;
    use traitActionable;
    use traitWithAttributes;

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
     * read
     *
     * @param  mixed $id
     * @return Model object readed from database
     */
    public function read($key): Model
    {
        $this->key = $key;
        $this->object = $this->model->findOrFail($key);
        return $this->object;
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

    /**
     * getValue
     *
     * @param  mixed $value
     * @return void
     */
    final function _get_Value($value)
    {
        return $value == 'null' ? null : $value;
    }
}
