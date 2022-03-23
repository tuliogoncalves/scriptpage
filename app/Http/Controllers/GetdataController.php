<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Scriptpage\Repository;

class GetdataController extends Controller
{
    private static function getRepository(String $model): Repository
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
