<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\UrlFilters\UserFilter;
use Illuminate\Support\Facades\DB;
use Scriptpage\Controllers\BaseController;


class UserController extends BaseController
{
    protected $cleanResponse = false;

    public function index(Request $request)
    {
        $query = User::query();
        // $query = DB::table('users');
        $query = UserFilter::apply($query);
        return $this->response($query);
    }

    public function create(Request $request)
    {
        return $this->response(
            User::make()->fill($request->all())
        );
    }

    public function show(User $user)
    {
        return $this->response(
            $user
        );
    }

    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->all());
        $user->save();
        return $this->response(
            $user
        );
    }

    public function store(UserRequest $request)
    {
        return $this->response(
            User::create($request->all())
        );
    }

    public function delete(User $user)
    {
        return $this->response([
            "deleted" => $user->delete()
        ]);
    }
}
