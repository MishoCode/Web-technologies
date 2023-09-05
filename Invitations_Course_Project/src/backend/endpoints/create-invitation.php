<?php

require_once '../controllers/invitation-controller.php';

session_start();

if (!$_SESSION['email']) {
    echo json_encode(["success" => false, "error" => "You have to log in"]);
    exit();
}

$invitationController = new InvitationController();
echo json_encode($invitationController->createInvitation());

?>