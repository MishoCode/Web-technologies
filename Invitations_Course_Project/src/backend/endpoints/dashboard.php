<?php
session_start();
$response = [];

if ($_SESSION) {
    if ($_SESSION["email"]) {
        $response = ["success" => true, "email" => $_SESSION["email"], "fn" => $_SESSION["fn"], "name" => $_SESSION["name"]];
    } else {
        $response = ["success" => false, "error" => "Unauthorized access"];
    }
} else {
    $response = ["success" => false, "error" => "Session expired"];
}

echo json_encode($response);

?>