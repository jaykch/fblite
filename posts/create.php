<?php
require '../utils/authentication.php';
require '../utils/queries.php';

$conn = login_system();

session_start();
$username = $_SESSION["username"];
$userId = fetch_user_id($conn, $username);
$body = isset($_POST['body']) ? $_POST['body'] : '';
create_post($conn, $userId, $body);
header("LOCATION: ../index.php");
exit();