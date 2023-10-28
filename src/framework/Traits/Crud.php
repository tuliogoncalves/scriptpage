<?php

/*
 * This file is part of scriptpage framework.
 *
 * (c) Túlio Gonçalves <tuliogoncalves@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scriptpage\Traits;

use Illuminate\Database\Eloquent\Model;

trait traitCrud
{

    /**
     * create a new instance
     * @param array $attributes
     * @return $self
     */
    static function create(array $data = [])
    {
        $model = $this->newInstance()->forceFill($data);
        $model->makeVisible($model->getHidden());
        return $model;
    }

    /**
     * Summary of store
     * @param array $data
     * @param string $validationKey
     * @return $self
     */
    static function store(array $data = [])
    {
        $model = self::create($data);
        $model->save();

        return $model;
    }

    /**
     * update data to the database
     * @param mixed $id
     * @param array $data
     * @return $self
     */
    static function update($id, array $data = [])
    {
        $model = $this->findOrFail($id);
        $model->fill($data);
        $model->save();

        return $model;
    }

    static function delete($id)
    {
        $model = $this->model->findOrFail($id);
        return $model->destroy($id);
    }
}
