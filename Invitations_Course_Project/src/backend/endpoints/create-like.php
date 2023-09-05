<?php

require_once '../controllers/like-controller.php';

session_start();

if (!$_SESSION['email']) {
    echo json_encode(["success" => false, "error" => "You have to log in"]);
    exit();
}

$likeController = new LikeController();
echo json_encode($likeController->createLike());

?>