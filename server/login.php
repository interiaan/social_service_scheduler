<?php
header('Content-Type: application/json');

// Cleans HTML Outputs and show errors
error_reporting(E_ALL);
ini_set('display_errors', '1');
ob_start();

$authStatus = array();

try {
    if ($_SERVER['REQUEST_METHOD'] != "POST") {
        throw new Exception("Invalid Request Method");
    }

    $input = json_decode(file_get_contents("php://input"), true);

    $email = $input['email'];
    $password = $input['password'];

    include "connection.php";

    $loginAuth = $conn->prepare("SELECT user_name, user_id, user_role FROM users WHERE user_email = ? AND user_password = ?");
    $loginAuth->bind_param("ss", $email, $password);
    $loginAuth->execute();

    $userData = $loginAuth->get_result();
    if ($userData->num_rows > 0) {
        $userInformation = $userData->fetch_assoc();
    
        session_start();
        $_SESSION['userId'] = $userInformation['user_id'];
        $_SESSION['userRole'] = $userInformation['user_role'];

        $authStatus = array(
            "status" => "success",
            "message" => "Account Verified",
            "userName" => $userInformation['user_name']
        );
    } else {
        $authStatus = array(
            "status" => "success",
            "message" => "Account Unverified"
        );
    }



} catch (Exception $e) {
    http_response_code(400);

    $authStatus = array(
        "status" => "error",
        "message" => $e->getMessage()
    );
}

// Adds PHP Debug Messages in JSON
$serverOutput = ob_get_clean();
if ($serverOutput) {
    $authStatus['debug'] = $serverOutput;
}

echo json_encode($authStatus);
