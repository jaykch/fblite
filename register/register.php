<!DOCTYPE html>
<html>
<head>
    <title>Registered | FB Lite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" media="all" href="../layout.css"/>

</head>
<body>

<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">Register</a>
                    </li>
                </ul>
            </div>

        </nav>
    </div>
</header>
<?php
require '../utils/authentication.php';
require '../utils/queries.php';


$user = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$dob = isset($_POST['dob']) ? $_POST['dob'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$relationshipStatus = isset($_POST['relationshipStatus']) ? $_POST['relationshipStatus'] : '';
$visibilityStatus = isset($_POST['visibilityStatus']) ? $_POST['visibilityStatus'] : '';


$conn = login_system();
$numRowsUsername = check_user_exists($user, $conn);
$numRowsEmail = check_email_exists($email, $conn);

if ($numRowsUsername > 0) {
    header("LOCATION: ./index.php?error=usernameTaken");
} else if ($numRowsEmail > 0) {
    header("LOCATION: ./index.php?error=emailTaken");
} else {

    $query = 'INSERT INTO USERS ';
    $query .= '(USERNAME, PASSWORD, FULLNAME, EMAIL, DOB, GENDER, LOCATION, RELATIONSHIPSTATUS, VISIBILITYSTATUS)';
    $query .= 'VALUES (\'' . $user . '\', \'' . $password . '\', \'' . $name . '\', \'' . $email . '\', TO_DATE(\'' . $dob . '\', \'YYYY-MM-DD\'), \'' . $gender . '\', \'' . $location . '\', \'' . $relationshipStatus . '\', \'' . $visibilityStatus . '\')';

    $sql = oci_parse($conn, $query);
    $result = oci_execute($sql);

    if ($result) {
        echo "<div class='success container'>
            <div class='row'>
            <div class='col-md-12'>
            <div class='alert alert-success' role='alert'>
                <h1>User successfully created with the following details!</h1>
            </div>
                <ul style='list-style: none'>
                    <li>Username:  $user </li>
                    <li>Password:  $password </li>
                    <li>Name:  $name </li>
                    <li>Email: $email</li>
                    <li>Date of Birth:  $dob </li>
                    <li>Gender:  $gender </li>
                    <li>Location:  $location </li>
                    <li>Relationship Status:  $relationshipStatus </li>
                    <li>Visibility Status:  $visibilityStatus </li>
                </ul>
                </div>
                </div>
            </div>";
        sleep(5);
        session_start();
        $_SESSION["userId"] = fetch_user_id($conn, $user);
        $_SESSION["username"] = $user;
        $_SESSION["fullName"] = $name;
        $_SESSION["email"] = $email;
        $_SESSION["dob"] = $dob;
        $_SESSION["gender"] = $gender;
        $_SESSION["location"] = $location;
        $_SESSION["relationshipStatus"] = $relationshipStatus;
        $_SESSION["visibilityStatus"] = $visibilityStatus;
        $_SESSION["isAuthenticated"] = true;
        oci_close($conn);
        header("LOCATION: ../index.php");
        exit();
    } else {
        echo $result;
        oci_close($conn);
        exit();
    }
}
?>
