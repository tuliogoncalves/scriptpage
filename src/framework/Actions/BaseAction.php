<?php

namespace Scriptpage\Actions;

use App\Scriptpage\Contracts\IActionable;
use Illuminate\Support\Traits\Conditionable;
use App\Scriptpage\Contracts\traitActionable;
use App\Scriptpage\Contracts\traitWithAttributes;

abstract class BaseAction implements IActionable
{
    use Conditionable;
    use traitActionable;
    use traitWithAttributes;

    protected $parameters = [];

    protected $version = '0.0.0.0';

    abstract public function handle();

    /**
     * getVersion
     *
     * @return string
     */
    function getVersion()
    {
        return $this->version;
    }

    /**
     * getParameters
     *
     * @return string
     */
    function getParameters()
    {
        $r = '';
        foreach ($this->parameters as $name => $required)
            $r .= (($required) ? '*' : '') . $name . '; ';
        return $r;
    }

    /**
     * validateParameters
     *
     * @return string or Null
     */
    private function validateParameters()
    {
        $r = '';

        foreach ($this->parameters as $name => $required) {
            if ($required and $this->existsParameter($name) == false) {
                $r .= " $name is required.";
            }
        }

        return $r;
    }

    /**
     * validParameter
     *
     * @param  string $name
     * @return bool
     */
    private function existsParameter($name = '')
    {
        $r = false;
        if (isset($this->values[$name])) {
            $r = !empty($this->values[$name]);
        }
        return $r;
    }

    /**
     * runAction
     *
     * @return mixed
     */
    private function runAction()
    {
        $r = $this->validateParameters();
        if ($r <> '') throw new \Exception($r);

        $r = null;
        try {
            $r = $this->handle();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $r;
    }

    /**
     * make
     *
     * @return this
     */
    public static function make(array $data = null)
    {
        $action = app(static::class);
        if (is_array($data)) $action->fill($data);
        return $action;
    }
    
    /**
     * run
     *
     * @see $this->runAction()
     */
    public static function run(array $data = null)
    {
        $action = static::make($data);
        return $action->runAction();
    }

    /**
     * go
     *
     * @return mixed
     */
    function go()
    {
        return $this->runAction();
    }

    /**
     * Execute an action on the controller.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    // public function callAction($method, $parameters)
    // {
    //     return $this->{$method}(...array_values($parameters));
    // }
}
