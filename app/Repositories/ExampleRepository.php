<?php

namespace App\Repositories;

use App\Models\User;
use App\Scriptpage\Repository\BaseRepository;

class ExampleRepository extends BaseRepository
{

    protected string $modelClass = User::class;


    // function searchData(array $data)
    // {
    //     $this->search = $data['search'];
    //     $this->take = (int)(empty($data['take']) ? 5 : $data['take']);
    //     $this->paginate = (empty($data['paginate']) ? 'true' : $data['paginate']) == 'true';
    // }


    // protected function appends()
    // {
    //     return ['search' => $this->search];
    // }

    
    /**
     * Initialization
     */
    // function init()
    // {
    // }

    function getData($take = null, $paginate = null) {
        $query = $this->newQuery();
        
        if( !empty($this->search) ) {
            $query->orWhere('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        return $this->doQuery($query, $take, $paginate);
    }
}
