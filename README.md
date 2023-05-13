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
- whereBetween = $field:$min,$max
- orWhereBetween = $field:$min,$max
- join = $table:$field1,$field2
- leftJoin = $table:$field1,$field2
- rightJoin = $table:$field1,$field2
- take = $limit
- orderBy = $column:[$direction = 'asc']
- paginate = true|false

#### Comparisons
- equal
- greater
- greater_or_equal
- less
- less_or_equal
- in
- between
- not_between

## Examples

### Using repository by request

#### Model

- GET `api/model/users`

#### Where clausule

- GET `api/model/users?where=role_id:2`

- GET `api/model/users?where=role_id:2;name:ester`

- GET `api/model/users?where=role_id:2&orWhere=name:ester`

- GET `api/model/users?whereBetween=role_id:-1,5`

#### selecting fields

- GET `api/model/users?select=id,name,email`

#### Database

- GET `api/table/users`

#### Add relationship

GET `api/table/users?join=contacts:users.id,contacts.user_id`

    GET api/table/users
            ?join=contacts:users.id,contacts.user_id
            ;orders:users.id,orders.user_id
            &where=users.name:laravel
            ;o
            &select=users.*,contacts.phone,orders.price
