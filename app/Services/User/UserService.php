<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\AbstractBaseService;
use DB;

class UserService extends AbstractBaseService
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
        return $this->model->query()->latest();
    }

    /**
     * Get the user with the given id.
     *
     * @param  int  $id The id of the user you want to get.
     * @return Model
     */
    public function getUser($id)
    {
        return $this->model->whereId($id)->firstOrFail();
    }

    /**
     * Create new user record
     *
     * @param  array  $dataUser User resource.
     * @return Model User created.
     */
    public function createUser($dataUser)
    {
        $user = $this->model->create($dataUser);

        return $this->model->find($user->id);
    }

    /**
     * It deletes a user by their id
     *
     * @param int $id The id of the user you want to delete.
     *
     * @return bool
     */
    public function deleteBy($id)
    {
        $user = $this->model->findOrFail($id);

        $user->delete();

        return true;
    }
}
