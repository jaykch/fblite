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

function fetch_username($conn, $userId)
{
    $query = 'SELECT USERNAME FROM users WHERE ID LIKE \'' . $userId . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    $row = oci_fetch_array($sql, OCI_ASSOC + OCI_RETURN_NULLS);
    return $row['USERNAME'];
}

function fetch_posts($conn)
{
    $query = 'SELECT * FROM posts WHERE parent_id IS NULL ORDER BY id DESC';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    oci_fetch_all($sql, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW + OCI_NUM);
    return $res;
}

function fetch_reply($conn, $parentId)
{
    $query = 'SELECT * FROM posts WHERE parent_id LIKE \'' . $parentId . '\'';
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

function create_reply($conn, $parentId, $userId, $body)
{
    $query = 'INSERT INTO posts ';
    $query .= '(parent_id, user_id, body, timestamp) ';
    $query .= 'VALUES (\'' . $parentId . '\', \'' . $userId . '\', \'' . $body . '\', current_timestamp)';

    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    oci_close($conn);
}

function create_like($conn, $post_id)
{
    $query = 'INSERT INTO likes ';
    $query .= '(post_id, user_id) ';
    $query .= 'VALUES (\'' . $post_id . '\', \'' . $_SESSION["userId"] . '\')';

    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    oci_close($conn);
}

function fetch_likes($conn, $postId)
{
    $query = 'SELECT * FROM likes WHERE post_id LIKE \'' . $postId . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    oci_fetch_all($sql, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW + OCI_NUM);
    return $res;
}

function has_user_liked($conn, $postId)
{
    $query = 'SELECT id FROM likes WHERE post_id LIKE \'' . $postId . '\' AND user_id LIKE \'' . $_SESSION["userId"] . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    $numRowsLikes = oci_fetch_all($sql, $res);

    if ($numRowsLikes > 0) {
        return true;
    } else {
        return false;
    }
}

function search_users($conn, $data)
{
    $query = 'SELECT ID, USERNAME FROM users WHERE USERNAME LIKE \'%' . $data . '%\' OR EMAIL LIKE \'%' . $data . '%\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    oci_fetch_all($sql, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW + OCI_NUM);

    return $res;
}

function send_friend_request($conn, $userId2)
{
    $query = 'INSERT INTO friendships ';
    $query .= '(user_id1, user_id2, friends, startdate) ';
    $query .= 'VALUES (\'' . $_SESSION["userId"] . '\', \'' . $userId2 . '\', \'' . 'p' . '\' ,current_timestamp)';

    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    oci_close($conn);
}

function fetch_friend_requests($conn)
{
    $query = 'SELECT * FROM friendships WHERE user_id2 LIKE \'' . $_SESSION["userId"] . '\' AND FRIENDS = \'' . 'p' . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    oci_fetch_all($sql, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW + OCI_NUM);
    return $res;
}

function accept_request($conn, $requestId)
{
    $query = 'UPDATE FRIENDSHIPS ';
    $query .= 'SET FRIENDS = \'' . 'y' . '\' ';
    $query .= 'WHERE ID = \'' . $requestId . '\'';

    $sql = oci_parse($conn, $query);
    oci_execute($sql);
}

function delete_request($conn, $requestId)
{
    $query = 'DELETE FROM FRIENDSHIPS WHERE ID LIKE \'' . $requestId . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    oci_close($conn);
}

function is_friends($conn, $userId1, $userId2)
{
    $query = 'SELECT id FROM FRIENDSHIPS WHERE user_id1 LIKE \'' . $userId1 . '\' AND user_id2 LIKE \'' . $userId2 . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    $numRowsLikes = oci_fetch_all($sql, $res);

    if ($numRowsLikes > 0) {
        return true;
    } else {
        return false;
    }
}

function is_friends_accepted($conn, $userId1, $userId2)
{
    $query = 'SELECT id FROM FRIENDSHIPS WHERE user_id1 LIKE \'' . $userId1 . '\' AND user_id2 LIKE \'' . $userId2 . '\' AND FRIENDS = \'' . 'y' . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    $numRowsLikes = oci_fetch_all($sql, $res);

    if ($numRowsLikes > 0) {
        return true;
    } else {
        return false;
    }
}

function is_public($conn, $username)
{
    $query = 'SELECT VISIBILITYSTATUS FROM users WHERE USERNAME LIKE \'' . $username . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    $row = oci_fetch_array($sql, OCI_ASSOC + OCI_RETURN_NULLS);
    if ($row['VISIBILITYSTATUS'] == 1) {
        return true;
    } else {
        return false;
    }
}

function is_friends_post($conn, $username){
    $query = 'SELECT VISIBILITYSTATUS FROM users WHERE USERNAME LIKE \'' . $username . '\'';
    $sql = oci_parse($conn, $query);
    oci_execute($sql);
    $row = oci_fetch_array($sql, OCI_ASSOC + OCI_RETURN_NULLS);
    if ($row['VISIBILITYSTATUS'] == 2) {
        return true;
    } else {
        return false;
    }
}

?>