# Scriptpage Framework[^1]

> **Note:** This repository contains the core code of the Scriptpage framework. If you want to build an application using Laravel with scriptpage, you need know [Scriptpage Sail](https://github.com/tuliogoncalves/sail).

#### See a Starter with VueJS using scriptpage: [starter-with-vuejs](https://github.com/tuliogoncalves/starter-with-vuejs)

You want to know a little more about the Repository pattern? [Read this great article](http://scriptpage.com.br/using-scriptpage-repository).

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
- withSum = $relation1,$relation2,...

- where = $column,[$condition = 'equal']:$value
- orWhere = $column,[$condition = 'equal']:$value

- join = $table:$field1,$field2
- leftJoin = $table:$field1,$field2
- rightJoin = $table:$field1,$field2
- take = $limit
- orderBy = $column:[$direction = 'asc']
- paginate = true|false

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

- get `api/model/users`

#### Where clausule

- get `api/model/users?where=role_id:2`
- get `api/model/users?where=role_id:2;name:ester`
- get `api/model/users?where=role_id:2&orWhere=name:ester`
- get `api/model/users?where=role_id,between:34,52`

#### selecting fields

- get `api/model/users?select=id,name,email`

#### Database

- get `api/table/users`

#### Add relationship

get `api/table/users?join=contacts:users.id,contacts.user_id`

    get api/table/users
            ?join=contacts:users.id,contacts.user_id
            ;orders:users.id,orders.user_id
            &where=users.name:laravel
            &select=users.*,contacts.phone,orders.price

[^1]: A framework is an abstraction that links common code across multiple software projects to provide generic functionality. A framework can achieve specific functionality, by configuration, during application programming. Unlike libraries, it is the framework that dictates the flow of control of the application, called Inversion of Control..[wikipedia](https://pt.wikipedia.org/wiki/Framework)
