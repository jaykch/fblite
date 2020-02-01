<?php
require '../utils/authentication.php';
require '../utils/queries.php';

$conn = login_system();
session_start();
$requestId = isset($_POST['requestId']) ? $_POST['requestId'] : '';
delete_request($conn, $requestId);
header("LOCATION: ../index.php");
exit();