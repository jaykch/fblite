<?php

function login_user($username, $password, $conn)
{
    $query = 'SELECT * FROM users WHERE USERNAME LIKE \'' . $username . '\' AND PASSWORD LIKE \'' . $password . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    return oci_fetch_all($sql, $res);
}

function fetch_user_info($username, $conn)
{
    $query = 'SELECT * FROM users WHERE USERNAME LIKE \'' . $username . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    return oci_fetch_array($sql, OCI_ASSOC + OCI_RETURN_NULLS);
}

function check_user_exists($username, $conn)
{
    $query = 'SELECT USERNAME FROM users WHERE USERNAME LIKE \'' . $username . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    return oci_fetch_all($sql, $res);
}

function check_email_exists($email, $conn)
{
    $query = 'SELECT email FROM users WHERE email LIKE \'' . $email . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    return oci_fetch_all($sql, $res);
}

function delete_user($username, $conn)
{
    $query = 'DELETE FROM USERS WHERE USERNAME LIKE \'' . $username . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    oci_close($conn);
}

function update_user($username, $conn, $newUsername, $location, $relationshipStatus, $visibilityStatus)
{
    $query = 'UPDATE USERS ';
    $query .= 'SET USERNAME = \'' . $newUsername . '\' , LOCATION = \'' . $location . '\', RELATIONSHIPSTATUS  = \'' . $relationshipStatus . '\', VISIBILITYSTATUS = \'' . $visibilityStatus . '\'';
    $query .= 'WHERE USERNAME = \'' . $username . '\'';

    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    oci_close($conn);
}

?>