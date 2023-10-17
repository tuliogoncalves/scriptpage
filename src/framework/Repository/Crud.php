<?php

/*
 * This file is part of scriptpage framework.
 *
 * (c) Túlio Gonçalves <tuliogoncalves@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scriptpage\Repository;

use Illuminate\Database\Eloquent\Model;

class Crud
{

    /**
     * create a new instance
     * @param array $attributes
     * @return Model
     */
    static function create(Model $model, array $data = [])
    {
        $model = $model->newInstance()->forceFill($data);
        $model->makeVisible($model->getHidden());
        return $model;
    }

    /**
     * Summary of store
     * @param array $data
     * @param string $validationKey
     * @return Model
     */
    public function store(array $data = [])
    {
        $model = $this->create($data);
        $model->save();

        return $model;
    }

    /**
     * update data to the database
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data = [])
    {
        $model = null;

        $model = $this->model->findOrFail($id);
        $model->fill(array_merge($data, $validation->getDataPayload()));
        $model->save();

        return $model;
    }

    public function delete($id)
    {
        $model = $this->model->findOrFail($id);
        return $model->destroy($id);
    }
}
