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
- columns = $column | array($columns)
- with = $relation | array($relations)
- withCount = $relation | array($relations)
- withSum = $relation | array($relations)
- where = $field:$value | array($field:$value)
- orWhere = $field:$value | array($field:$value)
- whereBetween = $field:$min,$max
- orWhereBetween = $field:$min,$max
- take = $limit
- orderBy = $column:[$direction = 'asc']
- paginate = true | false

## Examples

### Using repository by request

#### Model

GET `api/data/users`

#### where

GET `api/data/users?where=role_id:2`

GET `api/data/users?where=role_id:2,name:ester`

GET `api/data/users?where=role_id:2&orWhere=name:ester`

GET `api/data/users?whereBetween=role_id:-1,5`

#### selecting fields

GET `api/data/users?columns=id,name,email`
