<?php

namespace App\Services;

use App\Services\Helper\FilterTrait;

abstract class AbstractBaseService
{
    /**
     * @var model Eloquent Model
     */
    protected $model;
}
