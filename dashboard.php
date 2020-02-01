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
        <?php
        require './posts/index.php'
        ?>
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
            <?php
            require './search.php'
            ?>
        </div>
    </div>
</div>