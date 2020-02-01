<?php
require '../utils/authentication.php';
require '../utils/queries.php';

$conn = login_system();

session_start();
$username = $_SESSION["username"];
$userId = fetch_user_id($conn, $username);
$parentId = isset($_POST['parentId']) ? $_POST['parentId'] : '';
$body = isset($_POST['body']) ? $_POST['body'] : '';
echo $parentId;
echo $body;
create_reply($conn, $parentId, $userId, $body);
header("LOCATION: ../index.php");
exit();