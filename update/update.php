<?php
session_start();
require '../utils/authentication.php';
require '../utils/queries.php';
$conn = login_system();
$user = $_SESSION['username'];
$newUsername = isset($_POST['username']) ? $_POST['username'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$relationshipStatus = isset($_POST['relationshipStatus']) ? $_POST['relationshipStatus'] : '';
$visibilityStatus = isset($_POST['visibilityStatus']) ? $_POST['visibilityStatus'] : '';
update_user($user, $conn, $newUsername, $location, $relationshipStatus, $visibilityStatus);
$_SESSION["username"] = $newUsername;
$_SESSION["location"] = $location;
$_SESSION["relationshipStatus"] = $relationshipStatus;
$_SESSION["visibilityStatus"] = $visibilityStatus;

header("LOCATION: ../index.php");
exit()
?>
