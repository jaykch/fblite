<?php
require '../utils/authentication.php';
require '../utils/queries.php';

$conn = login_system();

session_start();
$username = $_SESSION["username"];
$postId = isset($_POST['postId']) ? $_POST['postId'] : '';
create_like($conn, $postId);
header("LOCATION: ../index.php");
exit();