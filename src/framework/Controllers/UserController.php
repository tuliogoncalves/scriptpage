<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Scriptpage\Controllers\BaseController;
use Scriptpage\Query\UrlFilter;

class UserController extends BaseController
{
    // protected $cleanResponse = true;

    public function index(Request $request)
    {
        $query = User::query();
        // $query = DB::table('users');
        $query = UrlFilter::apply($query);
        return $this->response( $query );
    }

}
