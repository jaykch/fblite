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
<ul>
    <?php
    if (isset($_POST['searchUser'])) {
        $data = $_POST['searchUser'];
        $searchUsers = search_users($conn, $data);

        foreach ($searchUsers as $searchUser) {
            if($searchUser[1] != $_SESSION["username"]){
                echo "<li>
                <form action=''>
                    <span class='d-block'>
                    id: $searchUser[0] <br>
                    $searchUser[1]
                    </span>
                    <button type='submit' class='btn btn-secondary'>Add Friend</button>
                </form>
                </li>";
            }

        }
    }

    ?>
</ul>