<?php

function login_system(){
    // Connects to the XE service (i.e. database) on the "localhost" machine
    $username = 's3770282';
    $password = 'testing11';
    $servername = 'talsprddb01.int.its.rmit.edu.au';
    $servicename = 'CSAMPR1.ITS.RMIT.EDU.AU';
    $connection = $servername . "/" . $servicename;
    $conn = oci_connect($username, $password, $connection);

    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    return $conn;
}