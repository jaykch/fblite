<h4>Search for people you may know</h4>
<br>
<form action="" method="post" class="search-user">
    <input type="search" name="searchUser" class="form-control d-block" required
           style="width: 100%" placeholder="username or email!"/>
    <br>
    <button type="submit" class="btn btn-primary">Search</button>
</form>
<script>

</script>
<br>
<ul class="search-results">
    <?php
    if (isset($_POST['searchUser'])) {
        $data = $_POST['searchUser'];
        $searchUsers = search_users($conn, $data);
        foreach ($searchUsers as $searchUser) {
            if ($searchUser[1] != $_SESSION["username"]) {
                if (!is_friends($conn, $_SESSION["userId"], $searchUser[0])) {
                    if(!is_friends($conn, $searchUser[0], $_SESSION["userId"])){
                        echo "<li class='search-result'>
                                <form action='./requests/sendRequest.php' method='post'>
                                    <input type='text' name='userId2' value=$searchUser[0] hidden>
                                    <span class='d-block'>$searchUser[1]</span>
                                    <button type='submit' class='btn btn-secondary'>Add Friend</button>
                                </form>
                              </li>";
                    }
                }
            }
        }
    }

    ?>
</ul>