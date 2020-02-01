<?php
require '../utils/authentication.php';
require '../utils/queries.php';

$conn = login_system();
session_start();

$userId2 = isset($_POST['userId2']) ? $_POST['userId2'] : '';
send_friend_request($conn, $userId2);
header("LOCATION: ../index.php");
exit();