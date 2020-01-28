<?php
session_start();
$_SESSION["isAuthenticated"] = true;
header("LOCATION: ../index.php?login=success");

exit();

//require '../utils/authentication.php';
//require '../utils/queries.php';
//$conn = login_system();
//
//$username = isset($_POST['username']) ? $_POST['username'] : '';
//$password = isset($_POST['password']) ? $_POST['password'] : '';
//
//$numRows = login_user($username, $password, $conn);
//$res = fetch_user_info($username, $conn);
//
//if ($numRows == 1) {
//    echo $res['username'];
//    foreach ($res as $col) {
//        foreach ($col as $item) {
//            echo " $item";
//        }
//    }
//$_SESSION["isAuthenticated"] = true;
//header("LOCATION: ../index.php?login=success");
//exit();
//
//} else {
//    header("LOCATION: ../index.php?error=loginFailed");
//}
//oci_close($conn);
?>
