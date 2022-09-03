<?php

namespace App\Services;

use Illuminate\Support\Arr;

abstract class AbstractBaseService
{
    /**
     * @var model Eloquent Model
     */
    protected $model;

    /**
     * Checks if the value is empty or null and returns a date from a string.
     *
     * @param mixed  $data
     * @param mixed  $index
     *
     * @return mixed
     */
    public function nullOrDate($data, $index)
    {
        $value = Arr::get($data, $index, null);

        return is_null($value) || $value === '' ? null : Carbon::parse($value);
    }

    /**
     * Returns the value if it's defined, or false otherwise.
     *
     * @param mixed  $data
     * @param mixed  $index
     *
     * @return mixed
     */
    public function valueOrFalse($data, $index)
    {
        if (empty($data[$index])) {
            return false;
        }

        return $data[$index];
    }
}
