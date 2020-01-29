<?php
session_start();
require '../utils/authentication.php';
require '../utils/queries.php';
$conn = login_system();
$user = $_SESSION['username'];
delete_user($user, $conn);

session_unset();
session_destroy();
$_SESSION["isAuthenticated"] = false;
header("LOCATION: ../index.php");
exit()
?>
