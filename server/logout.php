<?php

$logoutResponse = array();
try {
    session_start();
    session_unset();
    session_destroy();

    $logoutResponse = array(
        "status" => "success"
    );
} catch (Exception $e) {
    $logoutResponse = array(
        "status" => "error",
        "message" => $e
    );
}

echo json_encode($logoutResponse);