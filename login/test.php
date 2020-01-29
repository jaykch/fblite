<?php
session_start();

$_SESSION["username"] = "jaykch";
$_SESSION["fullName"] = "Jay Kumar";
$_SESSION["email"] = "jaykch@outlook.com";
$_SESSION["dob"] = "30/AUG/92";
$_SESSION["gender"] = "Male";
$_SESSION["location"] = "Melbourne";
$_SESSION["relationshipStatus"] = "Single";
$_SESSION["visibilityStatus"] = 1;
$_SESSION["isAuthenticated"] = true;
header("LOCATION: ../index.php?login=success");
