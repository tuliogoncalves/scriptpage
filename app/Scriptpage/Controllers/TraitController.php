<?php

namespace App\Scriptpage\Controllers;

use App\Scriptpage\Contracts\ICore;
use App\Scriptpage\Contracts\ICrud;
use App\Scriptpage\Contracts\IRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

trait TraitController
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
     * crud
     *
     * @var mixed
     */
    protected ICrud $crud;

    /**
     * core
     *
     * @var mixed
     */
    protected ICore $core;


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
     * coreClass
     *
     * @var mixed
     */
    protected $coreClass;


    /**
     * __construct
     *
     * @param  Request $request
     * @return TraitController
     */
    public function __construct(Request $request)
    {
        $this->repository = app($this->repositoryClass);
        if (!empty($this->crudClass)) $this->crud = app($this->crudClass);
        if (!empty($this->coreClass)) $this->core = app($this->coreClass);
        $this->repository->requestData($request);
        $this->bootstrap();

        return $this;
    }


    /**
     * setBack
     *
     * @param  Request $request
     * @return void
     */
    public function setBack(Request $request)
    {
        session(['url' => $request->fullUrl()]);
    }


    /**
     * Custom init
     *
     * @return void
     */
    protected function bootstrap()
    {
    }


    /**
     * RedirectTo
     *
     * @param  mixed $id
     * @param  mixed $id2
     * @return array
     */
    protected function RedirectTo($id = null, $id2 = null)
    {
        return [
            'store' => null,
            'update' => null,
            'destroy' => null
        ];
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
     * Get redirect url
     *
     * @param String $route
     * @param  mixed $id
     * @param  mixed $id2
     * @return String
     */
    final function getUrl(string $route = 'index', $id = null, $id2 = null)
    {
        $url = null;

        $redir = $this->RedirectTo($id, $id2);

        if (is_array($redir)) {
            $url = $redir[$route] ?? null;
        } else {
            $url = $redir;
        }

        $url = empty($url)
            ? session('url')
            : $url;

        return $url;
    }
}
