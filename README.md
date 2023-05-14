# Scriptpage Framework

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

### URL query options
- select = $column | array($columns)
- with = $relation | array($relations)
- withCount = $relation | array($relations)
- withSum = $relation | array($relations)
- where = $field,[$comparisons = 'equal']:$value | array($field,[$comparisons = 'equal']:$value)
- orWhere = $field,[$comparisons = 'equal']:$value | array($field,[$comparisons = 'equal']:$value)
- join = $table:$field1,$field2
- leftJoin = $table:$field1,$field2
- rightJoin = $table:$field1,$field2
- take = $limit
- orderBy = $column:[$direction = 'asc'] | array($column:[$direction = 'asc'])
- paginate = true|false

> array is separated by semicolons, example: expresion1; expression2; expresion3...

#### Comparisons
- equal

        $field:$value

- greater

        $field,greater:$value

- greater_or_equal

        $field,greater_or_equal:$value

- less

        $field,less:$value

- less_or_equal

        $field,less_or_equal:$value

- in
    **multiple comparisons, must be the last clause**

        $field,in:$value1,$value2,$value3...


- between
        $field,between:$value
- not_between
        $field,not_between:$value

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
            ;o
            &select=users.*,contacts.phone,orders.price
