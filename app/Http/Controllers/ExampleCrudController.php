<?php

namespace App\Http\Controllers;

use App\Cruds\UserCrud;

use App\Repositories\UserRepository;
use App\Scriptpage\Controllers\CrudController;
use App\Scriptpage\Controllers\CrudTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ExampleBaseController extends CrudController
{
    protected $repositoryClass = UserRepository::class;
    protected $crudClass = UserCrud::class;

    protected $template = "Users";
}
