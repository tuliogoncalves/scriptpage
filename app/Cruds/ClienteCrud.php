<?php

namespace App\Cruds;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Scriptpage\Repository\BaseCrud;

class ClienteCrud extends BaseCrud
{

    protected array $messages = [
        'same' => 'The :attribute and :other must match.',
        'size' => 'The :attribute must be exactly :size.',
        'between' => 'The :attribute value :input is not between :min - :max.',
        'in' => 'The :attribute must be one of the following types: :values',
    
        'email.required' => 'We need to know your email address!',
    ];


    protected array $customAttributes = [
        'email' => 'email address',
    ];


    protected string $modelClass = Cliente::class;

    
    function setDataValidation(): array
    {
        return [
            'name' => 'required|max:25',
            'email' => 'required|email',
            'cpf' => 'required|size:11',
            'telephone' => 'required|max:12',
            'birth' =>  'required|max:10',
            'state' => 'required|max:2',
            'city' => 'required|max:25',
            'address' => 'required|max:100',
        ];
    }

    function setDataPayload(array $data): array
    {
        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'cpf' => $data['cpf'],
            'telephone' => $data['telephone'],
            'birth' => $data['birth'],
            'state' => $data['state'],
            'city' => $data['city'],
            'address' => $data['address'],
        ];
    }


    // function setStoreDataPayload(array $data): array
    // {
    //     return [
    //         'created_at' => date('Y-m-d H:i:s')
    //     ];
    // }

    
    // Initialization
    //
    // function init()
    // {
    // }


    //  read
    // 
    // public function read($id): Model
    // {
    //     return parent::read($id);
    // }
    

    //  Create new record in database.
    //
    // function store()
    // {
    //     $user = parent::store();
    //     return $user;
    // }


    // update existing item.
    //
    // function update($id)
    // {
    //     $user = parent::update($id);
    //     return $user;
    // }


    // Delete item by primary key id.
    // 
    // public function delete($id): bool
    // {
    //     return parent::delete($id);
    // }
}
