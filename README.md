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
- select($columns = array('*'))
- with(array $relations)
- withCount(array $relations)
- withSum(array $relations)
- where(string $field, $value)
- whereOr(string $field, $value)
- whereBetween(string $field, $value)
- take(int limit)
- orderBy($column, $direction = 'asc')
- paginate($boolean=true)

## Examples

### Using repository by request

without filter

GET `api/data/users`

with filter

GET `api/data/users?where=role_id:2`

GET `api/data/users?where=role_id:2,name:ester`

GET `api/data/users?orWhere=role_id:1-3`

GET `api/data/users?whereBetween=role_id:-1,5`

selecting fields

GET `api/data/users?columns=id,name,email`
