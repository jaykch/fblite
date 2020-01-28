<?php
session_start();
session_unset();
session_destroy();
$_SESSION["isAuthenticated"] = false;
header("LOCATION: ../index.php");

