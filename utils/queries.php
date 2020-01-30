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

function fetch_user_id($conn, $username)
{
    $query = 'SELECT ID FROM users WHERE USERNAME LIKE \'' . $username . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    $row = oci_fetch_array($sql, OCI_ASSOC + OCI_RETURN_NULLS);
    return $row['ID'];
}

function fetch_posts($conn)
{
    $query = 'SELECT * FROM posts';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    oci_fetch_all($sql, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW + OCI_NUM);
    return $res;
}

function create_post($conn, $userId, $body)
{
    $query = 'INSERT INTO posts ';
    $query .= '(user_id, body, timestamp) ';
    $query .= 'VALUES (\'' . $userId . '\', \'' . $body . '\', current_timestamp)';

    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    oci_close($conn);
}

function create_comment($conn, $parentId, $userId, $body)
{
    $query = 'INSERT INTO posts ';
    $query .= '(parent_id, user_id, body, timestamp) ';
    $query .= 'VALUES (\'' . $parentId . '\', \'' . $userId . '\', \'' . $body . '\', current_timestamp)';

    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    oci_close($conn);
}

?>