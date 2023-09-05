<?php

require_once '../services/user-service.php';
require_once '../mappers/user-mapper.php';

class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
    public function register()
    {
        $userModel = call_user_func('UserMapper::toModel', json_decode(file_get_contents('php://input'), true));
        $passwordHash = password_hash($userModel->getPassword(), PASSWORD_DEFAULT);
        $response = ["success" => true];

        try {
            $this->userService->addUser(
                $userModel->getFn(), $userModel->getEmail(),
                $passwordHash, $userModel->getFirstName(),
                $userModel->getLastName(), $userModel->getCourse(), $userModel->getSpecialty()
            );
        } catch (InvalidArgumentException $e) {
            $response["success"] = false;
            $response["error"] = $e->getMessage();
        }


        return $response;
    }

    public function login()
    {
        session_start();
        $userCredentials = json_decode(file_get_contents('php://input'), true);

        $email = $userCredentials["email"];
        $password = $userCredentials["password"];

        $response = ["success" => true];
        $user = null;
        try {
            $user = $this->userService->isUserValid($email, $password);

        } catch (InvalidArgumentException $e) {
            $response["success"] = false;
            $response["error"] = $e->getMessage();
        }

        if (isset($user)) {
            $_SESSION["email"] = $email;
            $_SESSION["name"] = $user["first_name"];
            $_SESSION["fn"] = $user["fn"];
        }

        return $response;
    }
}

?>