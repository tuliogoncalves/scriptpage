# Scriptpage Framework[^1]

> **Note:** This repository contains the core code of the Scriptpage framework. If you want to build an application using Laravel with scriptpage, you need know [Scriptpage Sail](https://github.com/tuliogoncalves/sail).

#### See a Starter with VueJS using scriptpage: [starter-with-vuejs](https://github.com/tuliogoncalves/starter-with-vuejs)

You want to know a little more about the Repository pattern? [Read this great article](http://scriptpage.com.br/using-scriptpage-repository).

## Config

### file Config/App.php

add:

        /*
        |--------------------------------------------------------------------------
        | Application Version
        |--------------------------------------------------------------------------
        |
        | This value is the version of your application. This value is used when
        | the framework needs to place the application's version in a notification
        | or any other location as required by the application or its packages.
        */

        'version' => env('APP_VERSION', '1.0.0'),
        'project_name' => env('APP_PROJECT_NAME', 'app'),

## Methods

### Scriptpage\BaseRepository

#### CRUD
- create(array $attributes)
- update(array $attributes, $id)
- updateOrCreate(array $attributes, array $values = [])
- delete($id)
- deleteWhere(array $where)

### URL query filters

- select = $column1,$column2,...
- with = $relation1,$relation2,...
- withCount = $relation1,$relation2,...
- withSum = $relation:$column
- where = $column,[$condition = 'equal']:$value
- orWhere = $column,[$condition = 'equal']:$value
- join = $table:$field1,$field2
- leftJoin = $table:$field1,$field2
- rightJoin = $table:$field1,$field2
- take = $limit
- skip = $offset
- orderBy = $column:[$direction = 'asc']
- groupBy = $column1,$column2,...
- having = $column,[$condition = 'equal']:$value
- orHaving = $column,[$condition = 'equal']:$value
- paginate = true|false
- <CustomFilter> = $param1,$param2,...

> array is separated by semicolons, example: expresion1; expression2; expresion3...

### Conditions

- equal( = )

        $field:$value

- greater( > )

        $field,greater:$value

- greater_or_equal( >= )

        $field,greater_or_equal:$value

- less( < )

        $field,less:$value

- less_or_equal( <= )

        $field,less_or_equal:$value

- different ( <> )

        $field,different:$value

- null_safe ( <=> )

        $field,null_safe:$value

- in

        $field,in:$value1,$value2,$value3...

- not_in

        $field,in:$value1,$value2,$value3...

- like

        $field,like:$pattern

        $pattern, examples:

                _value*
                value*
                *value_*

- not_like

        $field,like:$pattern

- between

        $field,between:$value1, $value2

- not_between

        $field,not_between:$value1, $value2

## Examples

### Using repository by request

#### Model

- get `api/users`

#### With clausule

- get `api/users?select=id,name,email&with=roles`

#### Where clausule

- get `api/users?where=role_id:2`
- get `api/users?where=role_id:2;name:ester`
- get `api/users?where=role_id:2&orWhere=name:ester`
- get `api/users?where=role_id,between:34,52`
- get `api/users?where=email_verified_at:2023-05-14 14.02.20`

#### to Sql

Show sql statement result

- get `api/users/sql?where=email_verified_at:2023-05-14 14.02.20`

#### selecting fields

- get `api/model/users?select=id,name,email`

#### Database

- get `api/users/db?select=name,email&where=id,greater:200`

#### Add relationship

get `api/table/users?join=contacts:users.id,contacts.user_id`

    get api/table/users
                ?join=contacts:users.id,contacts.user_id
                ;orders:users.id,orders.user_id
                &where=users.name:laravel
                &select=users.*,contacts.phone,orders.price

## Laravel Eloquent Query: Using WHERE with OR AND OR

### Make use of [Logical Grouping](https://laravel.com/docs/master/queries#logical-grouping)

        Model::where(function ($query) {
        $query->where('a', '=', 1)
                ->orWhere('b', '=', 1);
        })->where(function ($query) {
        $query->where('c', '=', 1)
                ->orWhere('d', '=', 1);
        });

### With parameters for a,b,c,d

    $a = 1;
    $b = 1;
    $c = 1;
    $d = 1;
    Model::where(function ($query) use ($a, $b) {
        return $query->where('a', '=', $a)
            ->orWhere('b', '=', $b);
    })->where(function ($query) use ($c, $d) {
        return $query->where('c', '=', $c)
            ->orWhere('d', '=', $d);
    });

## Add Global Exception

In file App\Exceptions\Handler@register, add:

        use traitResponse;

        $this->renderable(function (Exception $e, Request $request) {
           return $this->apiRenderableResponse($e, $request);
        });


[^1]: A framework is an abstraction that links common code across multiple software projects to provide generic functionality. A framework can achieve specific functionality, by configuration, during application programming. Unlike libraries, it is the framework that dictates the flow of control of the application, called Inversion of Control..[wikipedia](https://pt.wikipedia.org/wiki/Framework)
