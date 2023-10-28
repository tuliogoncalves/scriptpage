<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Scriptpage\Controllers\BaseController;

class RoleController extends BaseController
{
    /**
     * Summary of index
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->response(
            RoleService::listOfRoles()
        );
    }
}