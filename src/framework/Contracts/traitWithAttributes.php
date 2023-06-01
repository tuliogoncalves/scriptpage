<?php

namespace Scriptpage\Contracts;

trait traitWithAttributes
{
    protected $values = [];
    protected $outputs = [];
    protected $out_values = [];

    /**
     * Makes attributes accessible as properties by using the magic method __get
     *
     * @param  mixed $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->values[$key] ?? null;
    }

    /**
     * __set
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->values[$key] = $value;
        return $this;
    }

    /**
     * Merges the provided attributes with the existing attributes
     *
     * @param  mixed $data
     * @return void
     */
    public function fill(array $data):self
    {
        $this->values = array_merge($this->values, $data);
        return self;
    }

    /**
     * Retrieves all attributes
     *
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * set/get value in output
     *
     * @param  string $output
     * @param  mixed $value
     * @return mixed || void
     */
    // function output(String $output, $value = chr(1))
    // {
    //     if (isset($this->out_values[$output]) and $value==chr(1)) {
    //         return $this->out_values[$output];
    //     }
    //     $this->out_values[$output] = ($value==chr(1)) ? null : $value;
    // }
}
