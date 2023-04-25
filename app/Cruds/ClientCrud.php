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
            'email' => 'required|email',
            'cpf' => 'required|max:11',
        ];
    }

    function setDataPayload(array $data): array
    {
        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'cpf' => $data['cpf'],
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
