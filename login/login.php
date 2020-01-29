<?php
session_start();

require '../utils/authentication.php';
require '../utils/queries.php';
$conn = login_system();

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$numRows = login_user($username, $password, $conn);
$row = fetch_user_info($username, $conn);

if ($numRows == 1) {
    $_SESSION["username"] = $row['USERNAME'];
    $_SESSION["fullName"] = $row['FULLNAME'];
    $_SESSION["email"] = $row['EMAIL'];
    $_SESSION["dob"] = $row['DOB'];
    $_SESSION["gender"] = $row['GENDER'];
    $_SESSION["location"] = $row['LOCATION'];
    $_SESSION["relationshipStatus"] = $row['RELATIONSHIPSTATUS'];
    $_SESSION["visibilityStatus"] = $row['VISIBILITYSTATUS'];
    $_SESSION["isAuthenticated"] = true;
    header("LOCATION: ../index.php?login=success");
    oci_close($conn);
    exit();
} else {
    header("LOCATION: ../index.php?error=loginFailed");
    oci_close($conn);
    exit();
}
?>
