<?php

namespace App\Scriptpage\Contracts;

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
        // dd($this->values);
        return isset($this->values[$key]) ? $this->values[$key] : null;
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
        return $this->set($key,$value);
    }

    /**
     * set
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function set($key, $value)
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
    public function fill(array $data)
    {
        $this->values = array_merge($this->values, $data);
        return $this;
    }

    /**
     * Retrieves all attributes
     *
     * @return array
     */
    public function all()
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
