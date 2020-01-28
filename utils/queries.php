<?php

function login_user($username, $password, $conn){
    $query = 'SELECT * FROM users WHERE USERNAME LIKE \'' . $username . '\' AND PASSWORD LIKE \'' . $password . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    return oci_fetch_all($sql, $res);
}

function fetch_user_info($username, $conn){
    $query = 'SELECT * FROM users WHERE USERNAME LIKE \'' . $username . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    oci_fetch_all($sql, $res);
    return $res;
}

function check_user_exists($username, $conn){
    $query = 'SELECT USERNAME FROM users WHERE USERNAME LIKE \'' . $username . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    return oci_fetch_all($sql, $res);
}

?>