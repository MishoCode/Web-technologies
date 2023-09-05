<?php
require_once '../database/config.php';
require_once '../repositories/user-repository.php';
require_once '../mappers/user-mapper.php';

class UserService
{
    private $userRepository;

    function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    function getAllUsers()
    {
        $users = $this->userRepository->getAllUsers();
        return array_map(array('UserMapper', 'toDto'), $users);
    }

    function addUser($fn, $email, $password, $firstName, $lastName, $course, $specialty)
    {
        if ($this->userRepository->findUserByFn($fn)) {
            throw new InvalidArgumentException("User with fn $fn already exists.");
        }

        if ($this->userRepository->findUserByEmail($email)) {
            throw new InvalidArgumentException("User with email $email already exists.");
        }

        $result = $this->userRepository->addUser($fn, $password, $email, $firstName, $lastName, $course, $specialty);
        return $result;
    }

    function isUserValid($email, $password)
    {
        $user = $this->userRepository->findUserByEmail($email);

        if (empty($user)) {
            throw new InvalidArgumentException("User with email $email does not exist.");
        }

        if (!password_verify($password, $user["password"])) {
            throw new InvalidArgumentException("Invalid password");
        }

        return $user;
    }
}


?>