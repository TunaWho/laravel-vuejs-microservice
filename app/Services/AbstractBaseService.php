<?php

namespace App\Services;

use App\Services\Helper\FilterTrait;

abstract class AbstractBaseService
{
    use FilterTrait;

    /**
     * @var model Eloquent Model
     */
    protected $model;
}
