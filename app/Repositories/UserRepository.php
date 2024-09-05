<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $entity;

    public function __construct(User $user)
    {
        $this->entity = $user;
    }

    /**
     * Get all Users
     * @return array
     */
    public function getAllUsers()
    {
        return $this->entity->all();
    }
    
    /**
     * Select User by ID
     * @param int $id
     * @return object
     */
    public function getUserById($id)
    {
        return $this->entity->find($id);
    }

    /**
     * Create a new user
     * @param array $data
     * @return object
     */
    public function createUser(array $data)
    {
        return $this->entity->create($data);
    }

     /**
     * Update data of user
     * @param object $user
     * @param array $data
     * @return object
     */
    public function updateUser(User $user, array $data)
    {
        return $user->update($data);
    }

    /**
     * Delete a user
     * @param object $user
     */
    public function destroyUser(User $user) 
    {
        return $user->delete();
    }
}