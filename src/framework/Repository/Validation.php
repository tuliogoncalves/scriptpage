<?php

namespace Scriptpage\Repository;
use Scriptpage\Assets\traitValidation;

// use Illuminate\Foundation\Http\FormRequest;

abstract class Validation
{
    use traitValidation;

    abstract function rules();
}
