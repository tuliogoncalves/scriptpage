<?php

namespace Scriptpage\Repository;
use Scriptpage\Repository\Assets\traitValidation;

// use Illuminate\Foundation\Http\FormRequest;

abstract class Validation
{
    use traitValidation;

    abstract function rules();
}
