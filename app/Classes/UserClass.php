<?php

namespace App\Classes;

use App\Models\User;

class UserClass
{
    private $model;


    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * This function retrieves all user records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Builder A query builder instance for the User model.
     *
     * @throws \Exception If any error occurs during the database query.
     */
    public function getAllUserList()
    {
        $query = User::query();
        return $query;
    }

    /**
     * Creates a new user or updates an existing user in the database.
     *
     * @param array $fields An associative array containing user data:
     *                      - 'name': The name of the user
     *                      - 'email': The email address of the user
     *                      - 'password': The password for the user
     * @param int|null $user_id The ID of an existing user to update (optional)
     *
     * @return User The created or updated User model instance
     */
    public function createUser($fields, $user_id = null)
    {
        if ($user_id) {
            $user = User::find($user_id);
        } else {
            $user = new User();
        }
        $user->name = $fields['name'];
        $user->email = $fields['email'];
        $user->password =  $fields['password'];
        $user->save();
        return $user;
    }

    /**
     * Saves user meta data.
     *
     * @param User $user The user model instance.
     * @param array $metaFields An associative array containing meta field names and their corresponding values.
     * @param array
     **/
    public function saveUserMeta($user, $metaFields)
    {
        $meta_fields = $this->model->meta_fields;
        $metaData = array();
        foreach ($meta_fields as $meta_field) {
            if (isset($metaFields[$meta_field])) {
                $metaData[$meta_field] = $metaFields[$meta_field];
            }
        }
        $user->setMeta($metaData);
        $user->save();
        return true;
    }
}
