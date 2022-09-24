<?php

namespace App\Http\Controllers;

use App\Scriptpage\Contracts\IRepository;
use Illuminate\Http\Request;

class GetdataController extends Controller
{
    private static function getRepository(String $model): IRepository
    {
        $class = [
            'UserRepository' => 'App\Repositories\UserRepository'
        ];

        return new $class[$model . 'Repository'];
    }

    public function getData(Request $request, String $model)
    {
        $repository = self::getRepository($model);
        $repository->requestData($request);
        return $repository->getData();
    }
}
