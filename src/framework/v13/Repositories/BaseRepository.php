<?php

namespace App\Repositories;

use Scriptpage\Repository\BaseRepository as ScriptpageRepository;

abstract class BaseRepository extends ScriptpageRepository
{

    /**
     * Request paginate data.
     */
    protected $search;
    protected $take = 5;
    protected $paginate = true;

    
    function searchData(array $data)
    {
        $this->search = empty($data['search']) ? '' : $data['search'];
        $this->take = (int)(empty($data['take']) ? 5 : $data['take']);
        $this->paginate = (empty($data['paginate']) ? 'true' : $data['paginate']) == 'true';
    }

    /**
     * @return array()
     */
    protected function appends()
    {
        return ['search' => $this->search];
    }

}
