<?php
require "_testData.php";

?>

<div class='container'>
    <br>
    <div class="row">
        <div class="col-md-3">
            <h3>Hello, <?php echo $_SESSION['username']; ?></h3>
            <h4>Your Details:</h4>
            <ul class="details">
                <li>Username: <?php echo $_SESSION['username']; ?> </li>
                <li>Name: <?php echo $_SESSION['fullName']; ?> </li>
                <li>Email: <?php echo $_SESSION['email']; ?> </li>
                <li>Date of Birth: <?php echo $_SESSION['dob']; ?>  </li>
                <li>Gender: <?php echo $_SESSION['gender']; ?>  </li>
                <li>Location: <?php echo $_SESSION['location']; ?>  </li>
                <li>Relationship Status: <?php echo $_SESSION['relationshipStatus']; ?>  </li>
                <li>Visibility Status: <?php if ($_SESSION['visibilityStatus'] == 1) {
                        echo "Public";
                    } else if ($_SESSION['visibilityStatus'] == 2) {
                        echo "Friends only";
                    } else if ($_SESSION['visibilityStatus'] == 3) {
                        echo "Private";
                    } ?>  </li>
            </ul>
            <br>
            <form action='./update/index.php'>
                <button type="submit" class="btn btn-warning">Update Profile</button>
            </form>
            <br>
            <form action='./update/delete.php'
                  onsubmit="return confirm('Are you sure you want to delete your account?');">
                <button type="submit" class="btn btn-danger">Delete Profile</button>
            </form>
        </div>
        <div class="col-md-6">
            <h2>Posts</h2>
            <br>
            <form action="./posts/create.php" method="post">
                <textarea name="comment" rows="3" class="form-control d-block" required
                          style="width: 100%">Enter text here...</textarea>
                <br>
                <button type="submit" class="btn btn-primary">Create post</button>
            </form>
            <br>
        </div>
        <div class="col-md-3">
            <h2>Friend Requests</h2>
            <ul>
                <?php
                foreach ($_SESSION["friendRequests"] as $user) {
                    echo "<li>
                            <span class=\"d-block\">$user</span>
                            <button type=\"submit\" class=\"btn btn-dark\">Accept Request</button>
                            <br>
                          </li>";
                }
                ?>
            </ul>
            <br><br>
            <h4>Search for people you may know</h4>
            <br>
            <form action="./posts/create.php" method="post" class="search-user">
                <input type="search" name="searchUser" class="form-control d-block" required
                       style="width: 100%" placeholder="username or email!"/>
                <br>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <br>
            <ul>
                <?php
                foreach ($_SESSION["friendRequests"] as $user) {
                    echo "<li>
                            <span class=\"d-block\">$user</span>
                            <button type=\"submit\" class=\"btn btn-secondary\">Send Request</button>
                            <br>
                          </li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>