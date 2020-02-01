<?php

$friendRequests = fetch_friend_requests($conn);

echo "
        <div class='friend-requests'>
            <h2>Friend Requests</h2>
            <ul>
            ";

foreach ($friendRequests as $request) {
    $username = fetch_username($conn, $request[1]);

    echo "<li class='friend-request'>
            <span class='d-block'>$username</span>
            <div class='d-flex'>
            <form action='./requests/acceptRequest.php' method='post'>
                <input type='text' hidden name='requestId' value='$request[0]' />
                <button type='submit' class='btn btn-dark'>Accept</button>
            </form>
            <form action='./requests/rejectRequest.php' method='post' class='ml-auto'>
                <input type='text' hidden name='requestId' value=$request[0] />
                <button type='submit' class='btn btn-danger'>Reject</button>
            </form>
            </div>
          </li>";
}

echo "     </ul>
            <br><br>
        </div>
";