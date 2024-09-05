<?php

namespace App\Services;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Select all users
     * @return array
    */
    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

     /**
     * Create a new user
     * @param array $data
     * @return object 
    */
    public function makeUser(array $data, $file)
    {
        $user = $this->userRepository->createUser($data);

        return $user;
    }

    /**
     * Get User by  ID
     * @param int $id
     * @return object
    */
    public function getUserById(int $id)
    {
        return $this->userRepository->getUserById($id);
    }

    /**
     * Update a user
     * @param int $id
     * @param arrray $data
     * @return json response
    */
    public function updateUser(int $id, array $data)
    {
        $user = $this->userRepository->getUserById($id);

        if (!$user) {
            return response()->json(['message' => 'User Not Found'], 404);
        }

        $this->userRepository->updateUser($user, $data);
        return response()->json(['message' => 'User Updated'], 200);
    }

    /**
     * Delete a user
     * @param int $id
     * @return json response
    */
    public function destroyUser(int $id)
    {
        $user = $this->userRepository->getUserById($id);

        if (!$user) {
            return response()->json(['message' => 'User Not Found'], 404);
        }

        $this->userRepository->destroyUser($user);

        return response()->json(['message' => 'User Deleted'], 200);
    }
}