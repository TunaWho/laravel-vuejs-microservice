<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\AbstractBaseService;

class UserService extends AbstractBaseService
{
    /**
     * It returns the latest users from the database
     *
     * @return Model
     */
    public function users()
    {
        return User::query()->latest();
    }

    /**
     * Get the user with the given id.
     *
     * @param int  $id The id of the user you want to get.
     *
     * @return Model
     */
    public function getUserBy($id)
    {
        return User::query()
            ->whereId($id)
            ->firstOrFail();
    }

    /**
     * Create new user record
     *
     * @param array  $dataUser User resource.
     *
     * @return Model User created.
     */
    public function createUser($dataUser)
    {
        return User::firstOrCreate($dataUser);
    }

    /**
     * Create new user record
     *
     * @param int    $userId User's id.
     * @param array  $data   Should be update into database.
     *
     * @return Model User created.
     */
    public function updateBy($userId, $data)
    {
        $user = $this->getUserBy($userId);
        $user->update($data);

        return $user;
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
        $user = User::findOrFail($id);

        $user->delete();

        return true;
    }
}
