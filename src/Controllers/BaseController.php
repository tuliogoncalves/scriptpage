<?php

namespace App\Scriptpage\Controllers;

use App\Http\Controllers\Controller;
use App\Scriptpage\Contracts\ICrud;
use App\Scriptpage\Contracts\IRepository;
use App\Scriptpage\Contracts\IService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

use function PHPUnit\Framework\isEmpty;

class BaseController extends Controller
{

    /**
     * template
     *
     * @var string
     */
    protected $template;



    /**
     * repository
     *
     * @var IRepository
     */
    protected IRepository $repository;



    /**
     * service
     *
     * @var IService
     */
    protected IService $service;



    /**
     * crud
     *
     * @var mixed
     */
    protected ICrud $crud;


    /**
     * repositoryClass
     *
     * @var String
     */
    protected $repositoryClass;



    /**
     * crudClass
     *
     * @var String
     */
    protected $crudClass;
    protected $storeClass;
    protected $updateClass;
    protected $deleteClass;

    /**
     * serviceClass
     *
     * @var String
     */
    protected $serviceClass;


    /**
     * makeRepository
     *
     * @param  mixed $data
     * @return void
     */
    protected function makeRepository(array $requestInput)
    {
        $this->repository = $this->repositoryClass::make();
        $this->repository->searchData($requestInput);
        return $this->repository;
    }

    /**
     * makeCrudStore
     *
     * @param  mixed $data
     * @return ICrud
     */
    protected function makeCrud()
    {
        $this->crud = $this->crudClass::make();
        return $this->crud;
    }

    /**
     * makeCrudStore
     *
     * @param  mixed $data
     * @return IService
     */
    protected function makeService()
    {
        $this->service = $this->serviceClass::make();
        return $this->service;
    }

    /**
     * makeCrudStore
     *
     * @param  mixed $data
     * @return void
     */
    protected function makeCrudStore()
    {
        $this->crud = isset($this->storeClass)
            ? $this->storeClass::make()
            :  $this->crudClass::make();
        return $this->crud;
    }

    /**
     * makeCrudUpdate
     *
     * @param  mixed $data
     * @return void
     */
    protected function makeCrudUpdate()
    {
        $this->crud = isset($this->updateClass)
            ? $this->updateClass::make()
            : $this->crudClass::make();
        return $this->crud;
    }

    /**
     * makeCrudUpdate
     *
     * @param  mixed $data
     * @return void
     */
    protected function makeCrudDelete()
    {
        $this->crud = isset($this->deleteClass)
            ? $this->deleteClass::make()
            : $this->crudClass::make();
        return $this->crud;
    }

    /**
     * render
     *
     * @param  mixed $component
     * @param  mixed $props
     * @return \Inertia\Response
     */
    final function render($component, $props = []): Response
    {
        return Inertia::render($component, $props);
    }



    /**
     * setBack
     *
     * @param  Request $request
     * @return void
     */
    final function setSessionUrl(Request $request)
    {
        session(['url' => $request->fullUrl()]);
    }



    /**
     * Get redirect url
     *
     * @param String $route
     * @param  mixed $id
     * @param  mixed $id2
     * @return String
     */
    // final function getUrl(string $route = 'index', $id = null, $id2 = null)
    final function getSessionUrl()
    {
        return session('url');
    }
    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @param bool $valida
     * @return Response
     */
    public function sendResponse($component, $result, $message = null, bool $success = true, int $code = 200): Response
    {
        $resp = [
            'success'   => $success,
            'paginator' => null,
            'data'      => null,
            'code'      => $code,
            'message'   => $message,
        ];
        $response = array_merge($resp, $result);
        return $this->render($component, $response);
    }



    /**
     * api response method.
     *
     * @param $result
     * @param $message
     * @param bool $valida
     * @return JsonResponse
     */
    public function sendApiResponse($result, $message = null, bool $success = true, int $code = 200): JsonResponse
    {
        $resp = [
            'success'   => $success,
            'paginator' => null,
            'data'      => null,
            'code'      => $code,
            'message'   => $message,
        ];
        $response = array_merge($resp, $result);
        return response()->json($response, $code);
    }
}
