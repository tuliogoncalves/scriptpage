<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Scriptpage\Contracts\IRepository;

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


    /**
     * serviceClass
     *
     * @var String
     */
    protected $serviceClass;


    /**
     * __construct
     *
     * @param  Request $request
     * @return BaseController
     */
    public function __construct(Request $request)
    {
        if (!empty($this->repositoryClass)) {
            $this->repository = app($this->repositoryClass);
            $this->repository->searchData($request->all());
        }

        if (!empty($this->crudClass)) $this->crud = app($this->crudClass);
        if (!empty($this->serviceClass)) $this->service = app($this->serviceClass);

        // Custom init
        $this->init();

        return $this;
    }



    /**
     * Custom init
     *
     * @return void
     */
    protected function init()
    {
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
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
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
    public function sendResponse($component, $result, $message=null, bool $success = true, int $code = 200): Response
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
}
