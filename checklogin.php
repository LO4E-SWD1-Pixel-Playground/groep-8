<?php
session_start();

$response = ['logged_in' => false];

if (isset($_SESSION['gebruikersnaam'])) {
    $response['logged_in'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
