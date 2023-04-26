<?php

namespace App\Cruds;

use Illuminate\Database\Eloquent\Model;
use App\Models\Fornecedores;
use App\Scriptpage\Repository\BaseCrud;

class FornecedorCrud extends BaseCrud
{

    protected array $customAttributes = [
        'email' => 'email address',
    ];

    protected string $modelClass = Fornecedores::class;

    function setDataValidation(): array
    {
        return [
            'name' => 'required|max:25',
            'email' => 'required|email',
            'cnpj' => 'required|size:11',
            'telefone' => 'required|max:12',
            'endereco' => 'required|max:100',
            'cidade' => 'required|max:25',  
        ];
    }

   
    function setDataPayload(array $data): array
    {
        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'cnpj' => $data['cnpj'],
            'telefone' => $data['telefone'],
            'endereco' => $data['endereco'],
            'cidade' => $data['cidade'],
        ];
    }

    //  function updateRoles($user)
    // {
    //      $data = $this->data;

    //     foreach ($user->roles as $role) {
    //          if (array_search($role->name, $data['roles']) === false) {
    //             $role->delete();
    //          }
    //      }

    //     foreach ($data['roles'] as $role) {
    //        Role::updateOrCreate([
    //            'user_id' => $user->id,
    //           'name' => $role
    //         ]);
    //     }
    //  }

    //  function store()
    //  {
    //      $user = parent::store();
    //     $this->updateRoles($user);
    //     return $user;
    // }

    //  function update($id)
    //  {
    //      $user = parent::update($id);
    //      $this->updateRoles($user);
    //     return $user;
    // }
}
