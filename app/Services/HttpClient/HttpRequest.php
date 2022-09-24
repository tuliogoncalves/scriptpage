<?php

namespace App\Services\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HttpRequest
{
    /**
     * client
     *
     * @var \GuzzleHttp\Client
     */
    private $client ;

    /**
     * reset
     *
     * @return void
     */
    public function reset()
    {
        $this->client = null;
        unset($this->client);
    }

    /**
     * getClient
     *
     * @return Client
     */
    private function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new Client($this->setConfig());
        }
        return $this->client;
    }

    /**
     * setConfig
     *
     * @return array
     */
    protected function setConfig()
    {
        return [
            'timeout'  => 4,
            'http_errors' => false
        ];
    }

    /**
     * request
     *
     * @param  mixed $method
     * @param  mixed $uri
     * @param  mixed $options
     * @return object
     */
    protected function request(string $method, $uri = '', array $options = [])
    {
        $response = null;
        $statusCode = 0;
        $mensagemErro = '';

        $client = $this->getClient();

        try {
            $response = $client->request($method, $uri, $options);
            $statusCode = $response->getStatusCode();
        } catch (RequestException $e) {
            $mensagemErro = $e->getMessage();
            if ($e->hasResponse()) {
                $statusCode = $e->getResponse()->getStatusCode();
            }
        }

        return (object) array(
            'response' => $response,
            'statusCode' => $statusCode,
            'mensagemErro' => $mensagemErro
        );
    }
}
