<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\BaseService;
use DB;

class UserService extends BaseService
{
    /**
     * Constructor function for models are using in this service.
     *
     * @param \App\Models\User $modelUser Instance resources.
     */
    public function __construct(User $modelUser)
    {
        $this->model = $modelUser;
    }

    /**
     * It returns the latest users from the database
     *
     * @return Model
     */
    public function users()
    {
        return $this->model->latest();
    }

    /**
     * Get the user with the given id.
     *
     * @param  int  $id The id of the user you want to get.
     * @return Model
     */
    public function getUser($id)
    {
        return $this->model->whereId($id)->first();
    }

    /**
     * Create new user record
     *
     * @param  array  $dataUser User resource.
     * @return Model User created.
     */
    public function createUser($dataUser)
    {
        try {
            return $this->model->create($dataUser);
        } catch (\Error $errors) {
            \Log::info($errors);

            return false;
        }
    }
}
