<?php

require_once '../controllers/user-controller.php';

$userController = new UserController();
echo json_encode($userController->login());

?>