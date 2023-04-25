<?php

namespace App\Cruds;

use App\Models\Client;
use App\Scriptpage\Repository\BaseCrud;

class ClientCrud extends BaseCrud
{
    protected string $modelClass = Client::class;

    function setDataValidation(): array
    {
        return [
            'name' => 'required|max:25',
            'cpf' => 'required|max:11',
            'email' => 'required|email',
            'birth' => 'required|date',
            'tel_num' => 'required|numeric',
            'cep' => 'required|max:11',
            'state' => 'required|max:35',
            'city' => 'required|max:35'
        ];
    }

    function setDataPayload(array $data): array
    {
        return [
            'name' => $data['name'],
            'cpf' => $data['cpf'],
            'email' => $data['email'],
            'birth' => $data['birth'],
            'tel_num' => $data['tel_num'],
            'cep' => $data['cep'],
            'state' => $data['state'],
            'city' => $data['city'],
        ];
    }


    function store()
    {
        $client = parent::store();
        return $client;
    }

    function update($id)
    {
        $client = parent::update($id);
        return $client;
    }
}
