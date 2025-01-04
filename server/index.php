<?php
session_start();

$sessionStatus = array();
try {
    if (!isset($_SESSION['userId'])) {
        throw new Exception("User not verified");
    }
    
    if (!isset($_SESSION['userRole'])) {
        throw new Exception("Unknowed role");
    }
    
    $sessionStatus = array(
        "status" => "success",
        "userId" => $_SESSION['userId'],
        "userRole" => $_SESSION['userRole']
    );
} catch (Exception $e) {
    $sessionStatus = array(
        "status" => "error",
        "message" => $e
    );
}

echo json_encode($sessionStatus);